<?php
App::uses('AppController', 'Controller');
App::uses('CakeEvent', 'Event');

/**
 * Users Controller
 *
 */
class UsersController extends AppController {

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$event = new CakeEvent('Users.afterLogin', $this, ['user' => $this->Auth->user()]);
				$this->getEventManager()->dispatch($event);
			}
			$this->autoRender = false;
		}
	}
	public function test_es() {
		$data = [
			'User' => [
				'full_name' => 'john smith',
			],
		];
		$this->User->save($data);
		die('test es done');
	}
}
