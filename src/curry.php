<?php
namespace yuyat;

class CurriedFunction implements \ArrayAccess
{
    private $fn;

    private $count;

    private $args;

    public function __construct($fn, $count, $args)
    {
        $this->fn = $fn;
        $this->count = $count;
        $this->args = $args;
    }

    public function apply($x)
    {
        $count = $this->count;
        $nextArgs = $this->args;

        foreach (func_get_args() as $arg) {
            $nextArgs[] = $arg;
            $count -= 1;

            if ($count < 1) {
                break;
            }
        }

        if ($count < 1) {
            return call_user_func_array($this->fn, $nextArgs);
        } else {
            return new static($this->fn, $count, $nextArgs);
        }
    }

    public function __invoke($x)
    {
        return call_user_func_array(array($this, 'apply'), func_get_args());
    }

    public function offsetGet($x)
    {
        return call_user_func_array(array($this, 'apply'), func_get_args());
    }

    public function offsetSet($key, $value)
    {
        throw new \BadMethodCallException(__METHOD__ . ' is not allowed');
    }

    public function offsetUnset($key)
    {
        throw new \BadMethodCallException(__METHOD__ . ' is not allowed');
    }

    public function offsetExists($key)
    {
        throw new \BadMethodCallException(__METHOD__ . ' is not allowed');
    }
}

function curry($fn, $count = null)
{
    if (!$count) {
        $ref   = callableToReflector($fn);
        $count = $ref->getNumberOfParameters();
    }

    return new CurriedFunction($fn, $count, array());
}
