<?php

class MyEventSource {
	protected $_eventCallbacks = array();
	
	function registerEventCallBack($callback) {
		$this->_callbacks[] = $callback;
	}
	
	function fireEvent() {
		foreach ($this->_callbacks as $callback) {
			call_user_func($callback);
		}
	}
}

/*$source = new MyEventSource();
$source->registerEventCallBack('testFunc');
$source->fireEvent();*/

class Dracula {	
	function __construct($hp, $attck) {
		$this->hp = $hp;
		$this->attck = $attck;
	}
}

$dracula = new Dracula(10,4);

function sun($dracula) {
	echo "Dracula steps out into the sun! WHY?!\n";
	$dracula->hp -= 5;
	echo "Dracula's health is now set to $dracula->hp";
}

$sun = new MyEventSource();
$sun->registerEventCallBack('sun');
$sun->fireEvent();
