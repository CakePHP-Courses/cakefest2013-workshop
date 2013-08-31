<?php

class FavoriteIterator extends IteratorIterator {

	protected $_user;

	protected $_cache;

	public function __construct($results, $userId) {
		$this->_user = $userId;
		$this->_cache = (array)Cache::read('favorites_' . $userId);
		parent::__construct($results);
	}

	public function current() {
		$current = parent::current();
		$current['User']['favorite'] = !empty($this->_cache[$current['User']['id']]);
		return $current;
	}
}
