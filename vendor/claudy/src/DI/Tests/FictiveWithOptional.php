<?php
namespace Ladis\DI\Tests;

use Ladis\DI\Tests\Fictive;
/**
 * Juste pour le test d'injection avec argument
 */
class FictiveWithOptional{
    protected $test;
    public function __construct ($arg = 300,$rr =__DIR__, Fictive $args){
        $this->test =$args;
    }
}