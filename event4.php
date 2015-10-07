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

    public function update(AbstractSubject $subject) {
        writeIn('*IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*');
        writeIn(' new favorite patterns: '.$subject->getFavorites());
        writeIn('*IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*');
    }
}

class PatternSubject extends AbstractSubject {
    private $favoritePatterns = NULL;
    private $observers = array();

    function __construct() {}

    function attach(AbstractObserver $observer_in) {
        // could also use array_push($this->observers, $observer_in);
        $this->observers[] = $observer_in;
    }

    function detach(AbstractObserver $observer_in) {
        // $key = array_search($observer_in, $this->observers);
        foreach($this->observers as $okey => $oval) {
            if($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }

    function notify() {
        foreach($this->observers as $obs) {
            $obs->update($this);
        }
    }

    function updateFavorites($newFavorites) {
        $this->favorites = $newFavorites;
        $this->notify();
    }

    function getFavorites() {
        return $this->favorites;
    }
}

writeIn('BEGIN TESTING OBSERVER PATTERN');
writeIn('');

$patternGossiper = new PatternSubject();
$patternGossipFan = new PatternObserver();
$patternGossiper->attach($patternGossipFan);
$patternGossiper->updateFavorites('abstract factory, decorator, visitor');
$patternGossiper->updateFavorites('abstract factory, decorator, visitor');
$patternGossiper->detach($patternGossipFan);
$patternGossiper->updateFavorites('abstract factory, observer, paisley');

writeIn('END TESTING OBSERVER PATTERN');

//=====Output=====
//BEGIN TESTING OBSERVER PATTERN

//IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*
//new favorite patterns: abstract factory, decorator, visitor
//IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*

//IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*
//new favorite patterns: abstract factory, observer, decorator
//IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*

//END TESTING OBSERVER PATTERN








