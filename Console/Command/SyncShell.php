<?php
App::uses('AppShell', 'Console/Command');
class SyncShell extends AppShell {

	public $uses = ['Company'];

	public $tasks = ['Gearman.GearmanWorker'];

	public function getOptionParser() {
		return parent::getOptionParser()
			->addSubCommand('worker', [
				'help' => 'Creates a worker process'
			])
			->addSubCommand('company', [
				'help' => 'Syncs company information from facebook',
				'parser' => [
					'arguments' => [
						'id' => [
							'help' => 'The company id',
							'required' => true
						]
					]
				]
			]);
	}

	public function worker() {
		$this->GearmanWorker->addFunction('sync_company', $this, 'processCompanyJob');
		$this->GearmanWorker->work();
	}

	public function processCompanyJob($data) {
		$this->args[0] = $data;
		$this->company();
	}

	public function company() {
		$data = $this->Company->find('first', ['conditions' => ['id' => $this->args[0]]]);
		$facebookId = $data['Company']['facebook_id'];

		try {
			$facebook = new Facebook(Configure::read('Facebook'));
			$company = $facebook->api('/' . $facebookId);
		} catch (Exception $e) {
			$this->error('Something bad happened: ' . $e->getMessage());
		}

		$data = $data['Company'];
		foreach ($company['location'] as $key => $location) {
			if (empty($location)) {
				continue;
			}
			$data[$key] = $location;
		}

		if (isset($company['website'])) {
			$data['website'] = $company['website'];
		}

		$this->Company->create();
		if ($this->Company->save($data, ['callbacks' => false])) {
			$this->log(sprintf('Company %s data was synced from facebook', $this->Company->id), 'info');
		}
	}

}
