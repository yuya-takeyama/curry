# yuyat\curry

Function does currying.

Virtually, it transforms functions takes multiple arguments into nested function each takes one argument like below.

```
f(x, y, z) => f(x)(y)(z)
```

And it can be applicated partially.
All of below means same.

```
f(x)(y)(z)
f(x)(y, z)
f(x, y)(z)
f(x, y, z)
```

## Usage

### Basic usage

```php
<?php
use function yuyat\curry;

$sum = function ($x, $y, $z)
{
    reteurn $x + $y + $z;
}

$curriedFunction = curry($sum);

echo $sum(1)->apply(2)->apply(3), PHP_EOL;
// => 6

echo $sum[1][2][3], PHP_EOL; // Ruby-like short syntax
// => 6
```

### Currying functions take variadic parameters

For functions take variadic parameters, you must specify actual parameter length as 2nd argument.


```
<?php
use function yuyat\curry;

$sum = function (/* numbers to calculate sum */)
{
    $result = 0;

    foreach (func_get_args() as $arg) {
        $result += $arg;
		}

    return $result;
}

$curriedFunction = curry($sum, 3);

echo $sum(1)->apply(2)->apply(3), PHP_EOL;
// => 6
```

## Author

Yuya Takeyama
