<?php

namespace Refinery29\Piston;

class CookieJar
{
    private $cookies;

    public function __construct(array $cookies = [])
    {
        $this->cookies = $cookies;
    }

    public function get($key)
    {
        return isset($this->cookies[$key])
            ? $this->cookies[$key]
            : null
            ;
    }

    public function set($key, $value)
    {
        $this->cookies[$key] = $value;
    }
}
