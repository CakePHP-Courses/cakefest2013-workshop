<?php
App::uses('AppController', 'Controller');
App::uses('CakeEvent', 'Event');
App::uses('FavoriteIterator', 'Iterator');
App::uses('SecurityIterator', 'Iterator');
App::uses('ListIterator', 'Iterator');

/**
 * Users Controller
 *
 */
class UsersController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow('redirectTest');
		parent::beforeFilter();
	}

	public function index() {
		$this->Crud->on('beforePaginate', function() {
			$this->User->switchToElastic();
			$this->Paginator->settings['limit'] = 20;
			if ($this->request->query('name')) {
				$this->Paginator->settings['query'] = [
					'match' => ['_all' => $this->request->query('name')]
				];
			}
		});
		$this->Crud->on('afterPaginate', function($event) {
			$event->subject()->items = new ListIterator(new SecurityIterator(
				$this->_buildFavoriteIterator(
					new ArrayIterator($event->subject()->items),
					$this->Auth->user('id')
				)
			));
		});
		return $this->Crud->executeAction();
	}

	protected function _buildFavoriteIterator($results, $user) {
		return new FavoriteIterator($results, $user);
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$event = new CakeEvent('Users.afterLogin', $this, ['user' => $this->Auth->user()]);
				$this->getEventManager()->dispatch($event);
			}
			$this->autoRender = false;
		}
	}

	public function redirectTest() {
		return $this->redirect(['controller' => 'companies', 'foo', 'bar', 'baz']);
		die('Nooo, I should not die');
	}

}
