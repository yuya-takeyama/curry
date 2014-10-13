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

    /**
     * @dataProvider provideCallable
     */
    public function test_curry_any_callable($fn)
    {
        $fn = curry($fn);

        $this->assertSame(9, $fn[1][2][3]);
    }

    public function provideCallable()
    {
        return array(
            array('yuyat\func'),
            array(array($this, 'method')),
            array(array(\get_class($this), 'staticMethod')),
            array('yuyat\CurryTest::staticMethod'),
        );
    }

    public function method($x, $y, $z)
    {
        return func($x, $y, $z);
    }

    public static function staticMethod($x, $y, $z)
    {
        return func($x, $y, $z);
    }
}

function func($x, $y, $z)
{
    return ($x + $y) * $z;
}
