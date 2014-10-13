<?php
namespace yuyat;

class CurryTest extends \PHPUnit_Framework_TestCase
{
    public function test_curry()
    {
        $func = curry(function ($x, $y, $z) {
            return ($x + $y) * $z;
        });

        $this->assertSame(9, $func->apply(1)->apply(2)->apply(3));
        $this->assertSame(9, $func->apply(1)->apply(2, 3));
        $this->assertSame(9, $func->apply(1, 2)->apply(3));
        $this->assertSame(9, $func->apply(1, 2, 3));

        $this->assertSame(9, $func(1)->__invoke(2)->__invoke(3));
        $this->assertSame(9, $func(1)->__invoke(2, 3));
        $this->assertSame(9, $func(1, 2)->__invoke(3));
        $this->assertSame(9, $func(1, 2, 3));

        $this->assertSame(9, $func[1][2][3]);
    }

    public function test_curry_variadic()
    {
        $func = curry(function (/* numbers to calculate sum */) {
            $result = 0;

            foreach (func_get_args() as $arg) {
                $result += $arg;
            }

            return $result;
        }, 3);

        $this->assertSame(6, $func->apply(1)->apply(2)->apply(3));

    }
}
