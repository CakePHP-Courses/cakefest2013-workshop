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

	public function processFacebookData(CakeEvent $event) {
		if ($event->subject() instanceof User) {
			$user = $event->subject();
			$data = $user->data[$user->alias];

			if (empty($data['work'])) {
				return true;
			}

			$ids = [];
			foreach ($data['work'] as $workPlace) {
				$user->Company->create();
				$user->Company->save([
					'name' => $workPlace['employer']['name'],
					'facebook_id' => $workPlace['employer']['id']
				]);
				$ids[] = $user->Company->id;
			}
			$user->data['Company']['Company'] = $ids;
			return true;
		}
	}
}
