<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Piston;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;

class RequestFactory extends ServerRequestFactory
{
    /**
     * @param array $server
     * @param array $query
     * @param array $body
     * @param array $cookies
     * @param array $files
     *
     * @return ServerRequest
     */
    public static function fromGlobals(
        array $server = null,
        array $query = null,
        array $body = null,
        array $cookies = null,
        array $files = null
    ) {
        $cookies = new CookieJar($cookies ?: $_COOKIE);
        $server = static::normalizeServer($server ?: $_SERVER);
        $files = static::normalizeFiles($files ?: $_FILES);
        $headers = static::marshalHeaders($server);
        $request = new Request(
            $cookies,
            $server,
            $files,
            static::marshalUriFromServer($server, $headers),
            static::get('REQUEST_METHOD', $server, 'GET'),
            'php://input',
            $headers
        );

        return $request
            ->withQueryParams($query ?: $_GET)
            ->withParsedBody($body ?: $_POST);
    }

    /**
     * @param string $uri
     *
     * @return ServerRequest
     */
    public static function createFromUri($uri)
    {
        return self::fromGlobals()->withUri(new Uri($uri));
    }
}
