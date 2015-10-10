<?php

function writeIn($line_in) {
    echo $line_in."\n";
}

class PatternObserver {
    public function __construct() {}
	
	// this is the event that gets triggered
    public function update($subject) {
        writeIn('*IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*');
        
        // get event status
        writeIn(' new favorite patterns: '.$subject->getFavorites());
        writeIn('*IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*');
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
    public function updateFavorites($newFavorites) {
        $this->favorites = $newFavorites;
        $this->notify();
    }
	
	// this is the bullet, ie DATA that gets sent to the event
    public function getFavorites() {
        return $this->favorites;
    }
}

class Priest extends PatternSubject {
	public function __construct() {}
	
	public $stats = array(
		'hp' => 10
	);
}

writeIn('BEGIN TESTING OBSERVER PATTERN');
writeIn('');

/**
 * will need a $player obj. to deal damage and echo state
 * and an interface class to receive user input
 */ 

$priest = new Priest();
$divineShield = new PatternObserver();
$priest->attach($divineShield);
$priest->updateFavorites('This will trigger Divine Shield.');
$priest->updateFavorites('This will trigger Divine Shield, but will have no charges left.');
$priest->detach($divineShield);
$priest->updateFavorites('This will try to trigger Divine Shield, but is now detached from the event.');

writeIn('END TESTING OBSERVER PATTERN');
writeIn('');
writeIn("Priest HP: ".$priest->stats['hp']);
