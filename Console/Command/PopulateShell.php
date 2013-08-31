<?php
App::uses('AppShell', 'Console/Command');
App::uses('String', 'Utility');
class PopulateShell extends AppShell {
	public $uses = array('User');
	public $tasks = array('ProgressBar');
	
	public function main() {
		$this->out('Inserting Elastic Search.');
		$faker = Faker\Factory::create();
		$this->User->switchToElastic();
		$count = 100;
		$this->ProgressBar->start($count);
		for($i = 1; $i <= $count; $i++){
			$lat_lon = array(
				'lat' => $faker->latitude, //37.630275 + $rand,
				'lon' => $faker->longitude //-122.359886 - $rand
			);
			$data = array(
				'id' => String::uuid(),
				'full_name' => $faker->name,
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'facebook_id' => $i,
				'companies' => array(array(
					'id' => String::uuid(),
					'name' => $faker->company,
					'street' => $faker->streetAddress,
					'city' => $faker->city,
					'state' => $faker->stateAbbr,
					'country' => $faker->country,
					'zip' => $faker->postcode,
					'website' => $faker->url,					
					'location' => $lat_lon
				)),
				'created' => '2013-08-30 12:00:00',
				'modified' => '2013-08-30 12:00:00'
			);
			$this->User->create();
			if (!$this->User->save($data, ['callbacks' => false])) {
				$this->out("ERROR on $i");
			}
			$this->ProgressBar->next();
		}

		$this->User->switchToDatabase();
		$this->out();
		$this->out('Done.');
	}
}
