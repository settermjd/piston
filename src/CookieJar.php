<?php

namespace Refinery29\Piston;

class CookieJar
{
    /**
     * @var array
     */
    private $cookies;

    /**
     * @param array $cookies
     */
    public function __construct(array $cookies = [])
    {
        if (!$this->isAssociative($cookies)) {
            throw new \InvalidArgumentException('CookieJar must be instantiated with an associative array');
        }

        $this->cookies = $cookies;
    }

    /**
     * @param $key
     */
    public function get($key)
    {
        return isset($this->cookies[$key])
            ? $this->cookies[$key]
            : null
            ;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->cookies[$key] = $value;
    }

    public function clear($key)
    {
        if (isset($this->cookies[$key])) {
            unset($this->cookies[$key]);
        }
    }

    public function clearAll()
    {
        $this->cookies = [];
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->cookies;
    }

    /**
     * @param $array
     *
     * @return bool
     */
    private function isAssociative($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
