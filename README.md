# Мultiple constructors in PHP

Constructor overload PHP methods, like in Java or C++

Based on articles (how to adopt this technics from Java to PHP):
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

## Valid scalar hints

- array
- callable
- bool	**not boolean!**
- float	**not double!**
- int	**not integer!**
- string	
- iterable
- object

## Simple cases of using multiple constructors

### Sample 1: int or string (city id or city code)

```php
class City {
  private $id;
  /**
   * @param $sityCode (id numeric; or string code of city)
   */
  public function __construct($cityCode) {
    if (is_numeric($cityCode)) {
      $this->id = function() use ($cityCode) { return $cityCode; };
    } elseif (is_string($cityCode)) {
      // constructor shuld be light, all real processing later
      $this->id = function() use ($cityCode) { 
        // resolve id by $cityCode
        // SELECT id FROM city WHERE code=[cityCode]
        return $cityCode; 
      };
    } else {
      throw new Exception("\$cityCode must be numeric or string");
    }
  }
  
  // Methods of City
  // ...
  public function info(): array {
    $id = $this->id->call($this); 
  }
}

### Sample 2: int or string (city id or city code)

```php
class City {
  private $id;
  /**
   * @param $sityCode (string; or object)
   */
  public function __construct($param) {
    if (is_string($param)) {
      $this->id = function() use ($cityCode) { return $cityCode; };
    } elseif (is_string($cityCode)) {
      $this->id = function() use ($cityCode) { 
        // resolve id by $cityCode
        // SELECT id FROM city WHERE code=[cityCode]
        return $cityCode; 
      };
    } else {
      throw new Exception("\$cityCode must be numeric or string");
    }
  }
  
  // Methods of City
  // ...
}

## Run tests

```bash
$ composer install
$ vendor/bin/phpunit OverloadedConstructorTest.php
```
