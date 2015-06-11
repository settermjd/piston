<?php namespace Refinery29\Piston\Hooks;

use Closure;
use InvalidArgumentException;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/10/15
 * Time: 5:44 PM
 */

class HookQueue
{
    private $hooks = [];

    public function addHook( $hook)
    {
        $this->validateHook($hook);

        $this->hooks[] = $hook;
        return $this;
    }

    public function getNext()
    {
        return array_shift($this->hooks);
    }

    public function insertHook($hook, $position)
    {
        $this->validateHook($hook);
        array_splice($this->hooks, $position, 0, $hook);

        return $this;
    }

    private function validateHook($hook)
    {
        if (!($hook instanceof Closure) && !($hook instanceof Hook)) {
            throw new InvalidArgumentException('You may only use closures and Refinery29/Piston/Hooks/Hook as a Hook');
        }
    }

    public function getHooks()
    {
        return $this->hooks;
    }
}
