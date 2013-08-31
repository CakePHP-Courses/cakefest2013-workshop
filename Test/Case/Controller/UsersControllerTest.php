<?php
App::uses('UsersController', 'Controller');

/**
 * UsersController Test Case
 *
 */
class UsersControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$controller = $this->generate('Users', [
			'components' => [
				'Auth' => ['user'],
				'Paginator' => ['paginate']
			],
			'models' => ['User' => ['switchToElastic']],
			'methods' => ['_buildFavoriteIterator']
		]);

		$results = [
			[
				'User' => [
					'id' => 'foo',
					'full_name' => 'bar',
					'companies' => [['id' => 'baz', 'country' => 'CakeLand']]
				]
			]
		];

		$controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('1234'));

		$controller->Paginator
			->expects($this->once())
			->method('paginate')
			->will($this->returnValue($results));

		$controller->User->expects($this->once())
			->method('switchToElastic');

		$controller->expects($this->once())
			->method('_buildFavoriteIterator')
			->with(new ArrayIterator($results), '1234')
			->will($this->returnValue(new ArrayIterator($results)));

		$dummy = $this->getMock('stdClass', ['tester']);
		$dummy->expects($this->once())->method('tester');

		$controller->getEventManager()->attach(function($event) use ($dummy) {
			$dummy->tester();
		}, 'Crud.afterPaginate');

		$this->testAction('/users.json', [
			'method' => 'GET'
		]);

		$response = json_decode($controller->response->body(), true);
		$expected = ['foo' => 'bar - CakeLand'];
		$this->assertEquals($expected, $response['data']);
	}

/**
 * testLogin method
 *
 * @return void
 */
	public function testRedirectTest() {
		$controller = $this->generate('Users');
		$this->testAction('/users/redirectTest');
		$this->assertEquals(Router::url('/companies/index/foo/bar/baz', true), $controller->response->location());
	}

}
