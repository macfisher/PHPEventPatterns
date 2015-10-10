<?php

abstract class AbstractObserver {
    abstract function update(AbstractSubject $subject_in);
}

abstract class AbstractSubject {
    abstract function attach(AbstractObserver $observer_in);
    abstract function detach(AbstractObserver $observer_in);
    abstract function notify();
}

function writeIn($line_in) {
    echo $line_in."\n";
}

class PatternObserver extends AbstractObserver {
    public function __construct() {}
	
	// this is the event that gets triggered
    public function update(AbstractSubject $subject) {
        writeIn('*IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*');
        
        // get event status
        writeIn(' new favorite patterns: '.$subject->getFavorites());
        writeIn('*IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*');
    }
}

class PatternSubject extends AbstractSubject {
    private $favoritePatterns = NULL;
    private $observers = array();

    function __construct() {}

    function attach(AbstractObserver $observer_in) {
        $this->observers[] = $observer_in;
    }

    function detach(AbstractObserver $observer_in) {
        foreach($this->observers as $okey => $oval) {
            if($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }
	
	// this is the trigger that fires the event
    function notify() {
        foreach($this->observers as $obs) {
            $obs->update($this);
        }
    }
	
	// this is the hand that pulls the trigger
    function updateFavorites($newFavorites) {
        $this->favorites = $newFavorites;
        $this->notify();
    }
	
	// this is the bullet, ie DATA that gets sent to the event
    function getFavorites() {
        return $this->favorites;
    }
}

writeIn('BEGIN TESTING OBSERVER PATTERN');
writeIn('');

/**
 * will need a $player obj. to deal damage and echo state
 * and an interface class to receive user input
 */ 

$priest = new PatternSubject();
$divineShield = new PatternObserver();
$priest->attach($divineShield);
$priest->updateFavorites('This will trigger Divine Shield.');
$priest->updateFavorites('This will trigger Divine Shield, but will have no charges left.');
$priest->detach($divineShield);
$priest->updateFavorites('This will try to trigger Divine Shield, but is now detached from the event.');

writeIn('END TESTING OBSERVER PATTERN');
