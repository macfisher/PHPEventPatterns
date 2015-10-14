<?php

function writeIn($line_in) {
    echo $line_in . "\n";
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

class PatternSubject {

    private $favoritePatterns = NULL;
    private $observers = array();

    public function __construct() {
        
    }

    public function attach($observer_in) {
        $this->observers[] = $observer_in;
    }

    public function detach($observer_in) {
        foreach ($this->observers as $okey => $oval) {
            if ($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }

    // this is the trigger that fires the event
    public function notify() {
        writeIn('TESTING NOTIFY and UPDATE');
        foreach ($this->observers as $obs) {
            $obs->update($this);
            var_dump($this);
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

class UserPrompt {

    public function __construct() {
        $this->printOptions();
        $input = $this->getInput();
        $this->handleInput($input);
    }

    public function printOptions() {
        writeIn('These are user options: ');
        writeIn('1. attack Priest.');
        writeIn('');
    }

    public function getInput() {
        $getInput = readline("Command: ");
        $input = $getInput;
        return $input;
    }

    public function handleInput($input) {
        switch($input) {
            case '1':
                writeIn('User signals to attack Priest.');
                $priest = new Priest();
                $combat = new Combat($priest);
                
                var_dump($priest->state['combat']);
                $priest->state['combat'] = 'attacking';
                
                $priest->attach($combat);
                var_dump($priest->state['combat']);
                $priest->updateState($priest->state);
                var_dump($priest->state['combat']);
                break;
            
            default:
                writeIn('Unknown command.');
                break;
        }
    }

}

// Combat Observer
class Combat {

    public function __construct() {
        
    }

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

class Priest extends PatternSubject {

    public function __construct() {
        
    }

    public $state = array(
        'hp' => 10,
        'combat' => 'neutral'
    );

}

writeIn('');

$userPrompt = new UserPrompt();

writeIn('');



/**
 * Notes: Order of operations:
 * 1. prompt user to attack Priest
 * 2. divine shield blocks first attack
 * 3. subsequent attacks do defined dmg.
 */
