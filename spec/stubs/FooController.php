<?php

namespace Refinery29\Piston\Stubs;

use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/9/15
 * Time: 4:39 PM
 */
class FooController
{
    public function fooAction(Request $req, Response $resp)
    {
        return $resp;
    }

    public function test(Request $req, Response $response)
    {
        return $response;
    }
}
