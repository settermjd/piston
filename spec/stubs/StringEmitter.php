<?php

namespace Refinery29\Piston\Stubs;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmitterInterface;

class StringEmitter implements EmitterInterface
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
        return $response->getBody()->__toString();
    }
}
