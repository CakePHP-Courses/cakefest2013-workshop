<?php

class SecurityIterator extends IteratorIterator {

	public function current() {
		$current = parent::current();
		unset($current['User']['last_name']);
		return $current;
	}
}

