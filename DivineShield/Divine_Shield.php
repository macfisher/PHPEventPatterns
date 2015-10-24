<?php

/**
 * Notes: Order of operations:
 * 1. prompt user to attack Priest
 * 2. divine shield blocks first attack
 * 3. subsequent attacks do defined dmg.
 */
writeIn('');

$userPrompt = new UserPrompt;
$userPrompt->printOptions();
$userPrompt->prompt();

writeIn('');

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

    //private $favoritePatterns = NULL;
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
        foreach ($this->observers as $obs) {
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

class UserPrompt {

    public function __construct() {
        $this->priest = new Priest();
        $this->combat = new Combat();
    }

    public function printOptions() {
        writeIn('These are user options: ');
        writeIn('1. attack Priest.');
        writeIn('');
    }

    public function prompt() {
        $prompt = readline("Command: ");
        $this->handlePrompt($prompt);
    }

    public function handlePrompt($prompt) {
        switch ($prompt) {
            case '1':
                writeIn('User signals to attack Priest.');
                

                $this->priest->state['combat'] = 'defending';

                $this->priest->attach($this->combat);
                $this->priest->updateState($this->priest->state);
                
                $this->prompt();
                break;

            default:
                writeIn('Unknown command.');
                $this->prompt();
                break;
        }
    }

}

// Combat Observer
class Combat {

    public function __construct() {
        $this->player = new Player(); // new player every time, doesn't work
    }

    public function update($subject) {
        writeIn('TESTING SUBJECT');
        var_dump($subject);
        writeIn('GET STATE: ');


        $getCombatState = $subject->getState();
        $combatState = $getCombatState['combat'];
        var_dump($combatState);

        switch ($combatState) {
            case 'attacking':
                writeIn('Subject is attacking.');
                break;

            case 'defending':
                writeIn('Subject is defending.');
                $targetHp =& $getCombatState['hp'];
                $playerAtk = $this->player->stats['attack'];
                
                $targetHp -= $playerAtk;
                
                writeIn('Subject has taken damage!');
                
                break;

            default:
                writeIn("Combat state is unknown.");
        }
    }

}

class Priest extends \PatternSubject {

    public $state = array(
        'hp' => 10,
        'combat' => 'neutral'
    );

}

class Player {
    // only the attack dmg is needed right now
    public $stats = array(
        'attack' => 3
    );
}