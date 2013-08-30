<?php

App::uses('CakeEventListener', 'Event');
class EventCentral implements CakeEventListener {

/**
 * Returns a list of all events that will fire in the model during it's lifecycle.
 * You can override this function to add you own listener callbacks
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Model.beforeSave' => 'processFacebookData'
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
	public function processFacebookData(CakeEvent $event) {
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

				try {
					$facebook = new Facebook(Configure::read('Facebook'));
					$company = $facebook->api('/' . $workPlace['employer']['id']);
				} catch (Exception $e) {
					die('An error occured');// @todo handle this
				}

				$user->Company->create();
				$data = [
					'name' => $workPlace['employer']['name'],
					'facebook_id' => $workPlace['employer']['id']
				];

				foreach ($company['location'] as $key => $location) {
					if (empty($location)) {
						continue;
					}

					$data[$key] = $location;
				}

				if (isset($company['website'])) {
					$data['website'] = $company['website'];
				}

				$user->Company->save($data);

				$ids[] = $user->Company->id;
			}
			$user->data['Company']['Company'] = $ids;
			return true;
		}
	}
}
