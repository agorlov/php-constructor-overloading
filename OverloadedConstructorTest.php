<?php

require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use AG\OverloadedConstructor;

final class OverloadedConstructorTest extends TestCase
{

    public function testConstructInt()
    {
        $obj = new class {
            private function constrInt(int $a) {}
            private function constrFloat(float $b) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrInt',
            (new OverloadedConstructor($obj, [ 1 ]))->constructor()
        );
    }

    public function testConstructFloat()
    {
        $obj = new class {
            private function constrInt(int $a) {}
            private function constrFloat(float $b) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrFloat',
            (new OverloadedConstructor($obj, [ 1.1 ]))->constructor()
        );
    }

    public function testConstructDoubleInt()
    {
        $obj = new class {
            private function constrInt(int $a) {}
            private function constrDoubleInt(int $a, int $b) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrDoubleInt',
            (new OverloadedConstructor($obj, [ 1, 2 ]))->constructor()
        );
    }

    public function testConstructIntNotDoubleInt()
    {
        $obj = new class {
            private function constrInt(int $a) {}
            private function constrDoubleInt(int $a, int $b) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrInt',
            (new OverloadedConstructor($obj, [ 2 ]))->constructor()
        );
    }

    public function testConstructStringNotCallable()
    {
        $obj = new class {
            private function constrString(string $a) {}
            private function constrCallable(callable $c) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrString',
            (new OverloadedConstructor($obj, [ 'Hello' ]))->constructor()
        );
    }

    public function testConstructCallableNotString()
    {
        $obj = new class {
            private function constrString(string $a) {}
            private function constrCallable(callable $c) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrCallable',
            (new OverloadedConstructor($obj, [ function() {} ]))->constructor()
        );
    }

    public function testConstructBooleanNotArray()
    {
        $obj = new class {
            private function constrBoolean(bool $a) {}
            private function constrArray(array $c) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrBoolean',
            (new OverloadedConstructor($obj, [ true ]))->constructor()
        );
    }

    public function testConstructArrayNotBoolean()
    {
        $obj = new class {
            private function constrBoolean(bool $a) {}
            private function constrArray(array $c) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrArray',
            (new OverloadedConstructor($obj, [ [ 'arr' ] ]))->constructor()
        );
    }


    public function testConstructDateTimeNotCallable()
    {
        $obj = new class {
            private function constrDateTime(\DateTime $a) {}
            private function constrCallable(callable $c) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrDateTime',
            (new OverloadedConstructor($obj, [ new DateTime() ]))->constructor()
        );
    }

    public function testConstructCallableNotDateTime()
    {
        $obj = new class {
            private function constrDateTime(\DateTime $a) {}
            private function constrCallable(callable $c) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrCallable',
            (new OverloadedConstructor($obj, [ function() {} ]))->constructor()
        );
    }


    public function testConstructArrayNotIterable()
    {
        $obj = new class {
            private function constrIterable(iterable $a) {}
            private function constrArray(array $c) {}
            public function __construct() {}
        };

        $this->assertEquals(
            'constrArray',
            (new OverloadedConstructor($obj, [ [ 'arr' ] ]))->constructor()
        );
    }

    public function testConstructIterableNotArray()
    {
        $obj = new class {
            private function constrIterable(iterable $a) {}
            private function constrArray(array $c) {}
            public function __construct() {}
        };

        $g = function() { yield 1; };
        $this->assertEquals(
            'constrIterable',
            (new OverloadedConstructor($obj, [ $g() ]))->constructor()
        );
    }
}
