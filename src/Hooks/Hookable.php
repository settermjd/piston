<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/17/15
 * Time: 2:58 PM
 */

namespace Refinery29\Piston\Hooks;


use InvalidArgumentException;

trait Hookable
{
    /**
     * @var Queue
     */
    protected $pre_hooks = null;

    /**
     * @var Queue
     */
    protected $post_hooks = null;

    public function addPreHook($hook)
    {
        $this->bootstrapHooks();
        $this->validateHook($hook);

        $this->pre_hooks->addHook($hook);

        return $this;
    }

    public function addPostHook($hook)
    {
        $this->bootstrapHooks();
        $this->validateHook($hook);

        $this->post_hooks->addHook($hook);

        return $this;
    }

    private function validateHook($hook)
    {
        if (!($hook instanceof \Closure) && !($hook instanceof Hook)) {
            throw new InvalidArgumentException('You may only use closures and Refinery29/Piston/Hooks/Hook as a Hook');
        }
    }

    public function getPreHooks()
    {
        $this->bootstrapHooks();
        return $this->pre_hooks;
    }

    public function getPostHooks()
    {
        $this->bootstrapHooks();
        return $this->post_hooks;
    }

    protected function bootstrapHooks()
    {
        if ($this->pre_hooks == NULL){
            $this->pre_hooks = new Queue();
        }

        if ($this->post_hooks == NULL){
            $this->post_hooks = new Queue();
        }
    }
}