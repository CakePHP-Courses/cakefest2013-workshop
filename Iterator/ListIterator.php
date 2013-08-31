<?php

class ListIterator extends IteratorIterator {

	public function key() {
		return parent::current()['User']['id'];
	}

	public function current() {
		$current = parent::current();
		return $current['User']['full_name'] . ' - ' . $current['User']['companies'][0]['country'];
	}
}


