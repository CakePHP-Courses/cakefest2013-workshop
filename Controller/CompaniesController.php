<?php
App::uses('AppController', 'Controller');
/**
 * Companies Controller
 *
 */
class CompaniesController extends AppController {

	public function map() {
		$companies = $this->Company->find('all');
		$this->set('companies', $companies);
	}

}
