<?php

namespace Refinery29\Piston\Stubs;

use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/9/15
 * Time: 4:39 PM
 */
class FooController
{
    public function fooAction(Request $req, ApiResponse $resp)
    {
        return $resp;
    }

    public function test(Request $req, ApiResponse $response)
    {
        $response->setResult(ResourceFactory::result(['something' => 'yolo']));

        return $response;
    }
}
