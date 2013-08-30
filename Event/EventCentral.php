<?php

App::uses('CakeEventListener', 'Event');
App::uses('GearmanQueue', 'Gearman.Client');

class EventCentral implements CakeEventListener {

/**
 * Returns a list of all events that will fire in the model during it's lifecycle.
 * You can override this function to add you own listener callbacks
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Model.beforeSave' => 'processCompanies',
			'Model.afterSave' => 'processFacebook'
		);
	}

/**
 * Proccess Facebook work data
 *  - if no work places skip it
 *  - lookup the place's location on Facebook
 *
 * @param  CakeEvent $event
 * @return boolean
 */
	public function processCompanies(CakeEvent $event) {
		if ($event->subject() instanceof User) {
			$user = $event->subject();
			$data = $user->data[$user->alias];

			if (empty($data['work'])) {
				return true;
			}

			$ids = [];
			foreach ($data['work'] as $workPlace) {
				$exists = $user->Company->find('first', [
					'field' => ['id'],
					'conditions' => [
						'facebook_id' => $workPlace['employer']['id']
					]
				]);

				if (!empty($exists)) {
					$ids[] = $exists['Company']['id'];
					continue;
				}

				$user->Company->create();
				$data = [
					'name' => $workPlace['employer']['name'],
					'facebook_id' => $workPlace['employer']['id']
				];
				$user->Company->save($data);
				$ids[] = $user->Company->id;
			}
			$user->data['Company']['Company'] = $ids;
			return true;
		}
	}

	public function processFacebook($event) {
		if ($event->subject() instanceof Company) {
			GearmanQueue::execute('sync_company', $event->subject()->id);
		}
	}

}
