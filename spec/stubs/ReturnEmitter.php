<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Piston\Stubs;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmitterInterface;

class ReturnEmitter implements EmitterInterface
{
    /**
     * Emit a response.
     *
     * @param ResponseInterface $response
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function emit(ResponseInterface $response)
    {
        return $response;
    }
}
