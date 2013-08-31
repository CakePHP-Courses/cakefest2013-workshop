<?php
App::uses('SyncShell', 'Console/Command');
App::uses('GearmanWorkerTask', 'Gearman.Console/Command/Task');

class SyncShellTest extends CakeTestCase {

/**
 * setup test
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$out = $this->getMock('ConsoleOutput', array(), array(), '', false);
		$in = $this->getMock('ConsoleInput', array(), array(), '', false);

		$this->Shell = $this->getMock(
			'SyncShell',
			array('in', 'out', 'hr', 'err', '_stop'),
			array($out, $out, $in)
		);
	}

	public function testWorker() {
		$this->Shell->GearmanWorker = $this->getMock('GearmanWorkerTask');
		$this->Shell->GearmanWorker->expects($this->once())
			->method('addFunction')
			->with('sync_company', $this->Shell, 'processCompanyJob');

		$this->Shell->GearmanWorker->expects($this->once())
			->method('work');

		$this->Shell->worker();
	}
}
