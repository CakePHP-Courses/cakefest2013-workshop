<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {

	public function login() {
		if ($this->request->is('post')) {
			$this->Auth->login();
			$this->autoRender = false;
		}
	}
}
