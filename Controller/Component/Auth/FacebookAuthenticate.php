<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class FacebookAuthenticate extends BaseAuthenticate {

public function authenticate(CakeRequest $request, CakeResponse $response) {
		$token = $request->data('fb_token');
		if (empty($token)) {
			return false;
		}

		$facebook = new Facebook(Configure::read('Facebook'));
		$facebook->setAccessToken($token);
		$user = $facebook->api('/me');
		$user = $this->_findOrCreateUser($user);

		return $user['User'];
	}

	protected function _findOrCreateUser($user) {
		$model = ClassRegistry::init('User');
		$found = $model->find('first', [
			'conditions' => ['facebook_id' => $user['id']]
		]);

		if ($found) {
			return $found;
		}

		$user['facebook_id'] = $user['id'];
		$user['full_name'] = $user['name'];
		unset($user['id']);

		$model->create();
		if ($user = $model->save($user)) {
			return $user;
		}

		throw new ForbiddenException('Something went wrong :(');
	}
}
