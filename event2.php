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
	private $callbacks = array();
	private $events = null;
	
	public function __construct() {
		$this->events = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><events></events>');
	}
	
	public function addListener($callback, $event) {}
	public function notify(Event &$event) {}
}
