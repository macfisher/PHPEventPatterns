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

$source = new MyEventSource();

foreach (range(1, 5) as $i) {
	$source->registerEventCallback('testFunc');
}

// will exec myFunction 5 times
$source->fireEvent();

/**
 * When defining a new class event, the following conventions should be followed:
 *
 * Define protected or private $Callbacks array.
 * Define protected or public registerCallback method.
 * Define fire method.
 */
 
 echo "\n";
 function testFunc() {
 	echo "Hello world\n";
 }


