<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Piston\Test\Unit;

use InvalidArgumentException;
use Refinery29\Piston\CookieJar;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class CookieJarTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testConstructorRejectsInvalidCookies()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $cookies = $this->getFaker()->words;

        new CookieJar($cookies);
    }

    public function testConstructorSetsCookies()
    {
        $cookies = $this->cookies();

        $cookieJar = new CookieJar($cookies);

        $this->assertSame($cookies, $cookieJar->all());
    }

    public function testCanSetValue()
    {
        $faker = $this->getFaker();

        $key = $faker->word;
        $value = $faker->word;

        $cookieJar = new CookieJar();

        $cookieJar->set($key, $value);

        $this->assertSame($value, $cookieJar->get($key));
    }

    public function testGetReturnsNullIfKeyNotFound()
    {
        $key = $this->getFaker()->word;

        $cookieJar = new CookieJar();

        $this->assertNull($cookieJar->get($key));
    }

    public function testCanClearCookie()
    {
        $cookies = $this->cookies();

        $key = array_rand($cookies, 1);

        $cookieJar = new CookieJar($cookies);

        $cookieJar->clear($key);

        unset($cookies[$key]);

        $this->assertSame($cookies, $cookieJar->all());
    }

    public function testCanClearCookieWhereValueIsNull()
    {
        $key = $this->getFaker()->word;

        $cookies = [
            $key => null,
        ];

        $cookieJar = new CookieJar($cookies);

        $cookieJar->clear($key);

        $this->assertSame([], $cookieJar->all());
    }

    public function testCanClearCookieEvenIfKeyDoesNotExist()
    {
        $key = $this->getFaker()->word;

        $cookieJar = new CookieJar();

        $cookieJar->clear($key);

        $this->assertSame([], $cookieJar->all());
    }

    public function testCanClearAllCookies()
    {
        $cookies = $this->cookies();

        $cookieJar = new CookieJar($cookies);

        $cookieJar->clearAll();

        $this->assertSame([], $cookieJar->all());
    }

    /**
     * @param int $count
     *
     * @return array
     */
    private function cookies($count = 5)
    {
        $faker = $this->getFaker();

        $count = $count ?: $faker->numberBetween(5, 15);

        return array_combine(
            $faker->words($count),
            $faker->words($count)
        );
    }
}
