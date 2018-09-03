# Мultiple constructors in PHP

Constructor overload PHP methods, like in Java or C++

For PHP > 7

Example:

```php
class CashOverloaded {
        private $kop;

        private function constrRubB(boolean $rub) {
                echo "constrRub boolean!\n";
        }

        private function constrRubD(double $rub, integer $kop) {
                echo "constrRub float!\n";
        }

        private function constrRubDate(float $rub, DateTime $dm) {
                echo "constrRub float!\n";
                $this->__construct($rub);
        }

        private function constrRub(float $rub) {
                echo "constrRub float!\n";
        }

        private function constrPrimary(int $kop) {
                echo "constrPrimary int!\n";
        }

        public function __construct() {
                $method = (new OverloadedConstructor($this, func_get_args()))->construct();
                echo "Method: $method!\n";
                $this->$method(...func_get_args());
        }

        public function money(): string {
        }
}


//new CashOverloaded(1.1, new DM);
new CashOverloaded(true);
```                          
