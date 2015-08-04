<?php namespace Refinery29\Piston\Hooks;

interface HasHooks
{
    public function getPreHooks();

    public function getPostHooks();
}
