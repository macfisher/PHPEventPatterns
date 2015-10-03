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
	
	public function addListener($callback, $event) {
		$return = false;
		
		if (is_callable($callback) === true) {
			if (is_array($callback)) {
				$id = md5(get_class($callback[0]) . json_encode($callback));
			} else {
				$id = md5(json_encode($callback));
			}
			
			$matches =& $this->_getEvent($event);
			
			foreach($matches as $match) {
				$status = $match->xpath('./listener[@id=\'' . $id . '\']');
				$status = ($status === false || count($status) === 0) ? false : true;
				
				if ($status === false) {
					$listener = $match->addChild('listener');
					$listener['id'] = $id;
					
					unset($listener);
				}
			}
			
			if (!isset($this->callback[$id])) {
				$this->callback[$id] =& $callback;
			}
			
			$return = true;
		}
		
		return $return;
	}
	
	// adds an event to the class events property and returns it as a pointer
	private function _build($node) {
		$nodes = explode('/', $node);
		$pointer =& $this->events;
		
		foreach($nodes as $node) {
			if (!isset($pointer->$node)) {
				$pointer->addChild($node);
			}
			
			$pointer =& $pointer->$node;
		}
		
		return array($pointer);
	}
	
	public function notify(Event &$event) {}
}






