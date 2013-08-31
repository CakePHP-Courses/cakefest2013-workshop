<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Facebook $Facebook
 * @property Company $Company
 */
class User extends AppModel {

/**
 * Returns the complete document mapping related to this model to be used in Elastic Search
 *
 * @return array
 **/
  public function elasticMapping() {
		return array(
			'id' => array('type' => 'string', 'index' => 'not_analyzed'),
			'full_name' => array('type' => 'string'),
			'first_name' => array('type' => 'string', 'include_in_all' => false),
			'last_name' => array('type' => 'string', 'include_in_all' => false),
			'companies' => array(
				'type'=> 'object',
				'properties' => array(
					'id' => array('type' => 'string', 'index' => 'not_analyzed'),
					'name' => array('type' => 'string'),
					'street' => array('type' => 'string'),
					'city' => array('type' => 'string'),
					'state' => array('type' => 'string'),
					'country' => array('type' => 'string'),
					'zip' => array('type' => 'string'),
					'website' => array('type' => 'string', 'length' => 2048),
					'location' => array('type' => 'geo_point', 'lat_lon' => true),
				)
			),
			'created' => array('type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'),
			'modified' => array('type' => 'date', 'format' => 'yyyy-MM-dd HH:mm:ss')
		);
	}

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'full_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Company' => array(
			'className' => 'Company',
			'joinTable' => 'companies_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'company_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	function afterSave($created) {
		$esData = $this->esDenormalize($this->data);
		$this->switchToElastic();
		$this->create();
		$this->save($esData, ['callbacks' => 'false']);
		$this->switchToDatabase();
	}

	function esDenormalize($data) {
		return $data;
	}
}
