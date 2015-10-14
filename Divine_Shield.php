<?php

function writeIn($line_in) {
    echo $line_in."\n";
}

/*
class PatternObserver {
    public function __construct() {}
	
    // this is the event that gets triggered
    public function update($subject) {
        var_dump($subject->getState());
    }
}
*/
 
class Combat {
    public function __construct() {}
	
    public function update($subject) {
        switch($subject->getState()) {
            case 'attacking':
                writeIn('Subject is attacking.');
                break;
            
            case 'defending':
                writeIn('Subject is defending.');
                break;
            
            default:
                writeIn("Combat state is unknown.");
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
	
	public $state = array(
		'hp' => 10,
		'combat' => 'attacking'
	);
}

/**
 * will need a $player obj. to deal damage and echo state
 * and an interface class to receive user input
 */ 
writeIn('');
$priest = new Priest();
$combat = new Combat();
$priest->attach($combat);

// need a combat class that will update the combat state of a subject obj.
$priest->updateState($priest->state['combat']);
$priest->detach($combat);
writeIn('');

/**
 * Notes: Order of operations:
 * 1. prompt user to attack Priest
 * 2. divine shield blocks first attack
 * 3. subsequent attacks do defined dmg.
 */
