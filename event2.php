<?php

class Event {
	private $name;
	private $parameters = array();
	
	public function __construct($name, array $parameters = array()) {
		$this->name = $name;
		$this->parameters = $parameters;
	}
	
	public function __get($propery) {
		if (isset($this->$property)) {
			return $this->$property;
		}
	}
}

class Dispatcher {
	
}
