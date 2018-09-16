# Мultiple constructors in PHP

Constructor overload PHP methods, like in Java or C++

Based on article (how to adopt this technic from Java to PHP):

https://www.yegor256.com/2015/05/28/one-primary-constructor.html

For PHP > 7

Example:

```php
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
}

var_dump(new Cash());
```                  

more examples: in ``example.php`` and ``example2.php``

## Valid scalar hints

- array
- callable
- bool	**not boolean!**
- float	**not double!**
- int	**not integer!**
- string	
- iterable
- object


## Tests

```bash
$ composer install
$ vendor/bin/phpunit OverloadedConstructorTest.php
```
