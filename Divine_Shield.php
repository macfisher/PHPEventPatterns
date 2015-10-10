<?php

function writeIn($line_in) {
    echo $line_in."\n";
}

class PatternObserver {
    public function __construct() {}
	
	// this is the event that gets triggered
    public function update($subject) {
        writeIn("Checking \$priest->stats['hp'] as STATE: HP = ".$subject->getState());
        
        if($subject->getState() < 10) {
        	writeIn("Priest has been WOUNDED!");
        }
    }
}

class PatternSubject {
    private $favoritePatterns = NULL;
    private $observers = array();

    public function __construct() {}

    public function attach($observer_in) {
        $this->observers[] = $observer_in;
    }

    public function detach($observer_in) {
        foreach($this->observers as $okey => $oval) {
            if($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }
	
	// this is the trigger that fires the event
    public function notify() {
        foreach($this->observers as $obs) {
            $obs->update($this);
        }
    }
	
	// this is the hand that pulls the trigger
    public function updateState($newState) {
        $this->state = $newState;
        $this->notify();
    }
	
	// this is the bullet, ie DATA that gets sent to the event
    public function getState() {
        return $this->state;
    }
}

class Priest extends PatternSubject {
	public function __construct() {}
	
	public $stats = array('hp' => 9);
}

/**
 * will need a $player obj. to deal damage and echo state
 * and an interface class to receive user input
 */ 
writeIn('');
$priest = new Priest();
$divineShield = new PatternObserver();
$priest->attach($divineShield);
$priest->updateState($priest->stats['hp']);
$priest->detach($divineShield);
writeIn('');
