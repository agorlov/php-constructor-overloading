<?php

require_once 'vendor/autoload.php';

use AG\OverloadedConstructor;

class DM extends DateTime
{
}

class CashOverloaded
{
    private $kop;

    private function constrRubB(bool $rub)
    {
        echo "constrRub boolean!\n";
    }

    private function constrRubD(double $rub, integer $kop)
    {
        echo "constrRub float!\n";
    }

    private function constrRubDate(float $rub, DateTime $dm)
    {
        echo "constrRub float!\n";
        $this->__construct($rub);
    }

    private function constrRub(float $rub)
    {
        echo "constrRub float!\n";
    }

    private function constrPrimary(int $kop)
    {
        echo "constrPrimary int!\n";
    }

    public function __construct()
    {
        $method = (new OverloadedConstructor($this, func_get_args()))->constructor();
        echo "Method: $method!\n";
        $this->$method(...func_get_args());
    }

    public function money(): string
    {
    }
}


//new CashOverloaded(1.1, new DM);
new CashOverloaded(true);
