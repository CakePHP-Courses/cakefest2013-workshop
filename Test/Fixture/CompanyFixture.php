<?php
/**
 * CompanyFixture
 *
 */
class CompanyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'street' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'zip' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '8,6'),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '8,6'),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2048, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'facebook_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'unique'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'facebook_id_UNIQUE' => array('column' => 'facebook_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '521fb5f2-0638-4e4b-95b7-246af4c4eed0',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'state' => 'Lorem ipsum dolor sit amet',
			'country' => 'Lorem ipsum dolor sit amet',
			'zip' => 'Lorem ipsum dolor sit amet',
			'latitude' => 1,
			'longitude' => 1,
			'website' => 'Lorem ipsum dolor sit amet',
			'user_count' => 1,
			'facebook_id' => '',
			'created' => '2013-08-29 20:58:26',
			'updated' => '2013-08-29 20:58:26'
		),
	);

}
