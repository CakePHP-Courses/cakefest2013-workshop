<?php
App::uses('AppShell', 'Console/Command');
App::uses('String', 'Utility');
class PopulateShell extends AppShell {
	public $uses = array('User');
	public $tasks = array('ProgressBar');
	
	public function run(){
		$this->out('Inserting Elastic Search.');
		$this->User->switchToElastic();
		$count = 100;
		$this->ProgressBar->start($count);
		for($i = 1; $i <= $count; $i++){
			$rand = mt_rand(1000,20000);
			$rand = $rand / 20000;
			$lat_lon = array(
				'lat' => 37.630275 + $rand,
				'lon' => -122.359886 - $rand
			);
			$data = array(
				'id' => String::uuid(),
				'full_name' => "Awesome $i Baker",
				'first_name' => "Awesome",
				'last_name' => "Baker",
				'facebook_id' => $i,
				'companies' => array(
					'id' => String::uuid(),
					'name' => "CakeOCD $i",
					'street' => "123 main street",
					'city' => "Gotham",
					'state' => "NY",
					'country' => "DC",
					'zip' => "12345",
					'website' => "http://cakephp.org",					
					'location' => $lat_lon
				),
				'created' => '2013-30-08 12:00:00',
				'modified' => '2013-30-08 12:00:00'
			);
			$this->User->create();
			if(!$this->User->save($data)){
				$this->out("ERROR on $i");
			}
			$this->ProgressBar->next();
		}
		$this->User->switchToDatabase();
		$this->out();
		$this->out('Done.');
	}
}
