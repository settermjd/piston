<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return isset($this->cookies[$key])
            ? $this->cookies[$key]
            : null
            ;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->cookies[$key] = $value;
    }

    /**
     * @param string $key
     */
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
     * @param array $array
     *
     * @return bool
     */
    private function isAssociative($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
