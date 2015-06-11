<?php namespace Refinery29\Piston\Hooks;
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/10/15
 * Time: 5:44 PM
 */

class HookQueue
{
    private $hooks = [];

    public function addHook(Hook $hook)
    {
        $this->hooks[] = $hook;
    }

    public function getNext()
    {
        return array_pop($this->hooks);
    }

    public function insertHook(Hook $hook, $position)
    {
        array_splice($this->hooks, $position, 1, $hook);
    }
}