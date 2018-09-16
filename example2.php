<?php

require_once 'vendor/autoload.php';

use AG\OverloadedConstructor;

final class Cash {
  /** @var int */
  private $cents; 
  /** @var string */
  private $currency;
  
  private function constrEmpty() { // secondary
    $this->__construct(0);
  }
  
  private function constrCnts(int $cts) { // secondary
    $this->__construct($cts, "USD");
  }
  
  private function constrPrimary(int $cts, string $crn) { // primary
    $this->cents = $cts;
    $this->currency = $crn;
  }
  
  public function __construct() {
    // overloaded constructors invocation
    $method = (new OverloadedConstructor($this, func_get_args()))->constructor();
    $this->$method(...func_get_args());  
  }
  
  // methods here
  public function print() {
    return (int) $this->cents/100 . " " . $this->currency;
  }
}

echo (new Cash())->print() . "\n";
echo (new Cash(123))->print() . "\n";
echo (new Cash(123, "CNY"))->print() . "\n";
