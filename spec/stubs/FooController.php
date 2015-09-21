<?php

namespace Refinery29\Piston\Stubs;

use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Router\Routes\Routeable;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/9/15
 * Time: 4:39 PM
 */
class FooController implements Routeable
{
    public function fooAction(Request $req, Response $resp)
    {
        return $resp;
    }

    public function test($req, $resp)
    {
        if ($req->isPaginated()) {
            echo '<pre>' . print_r($req->getPaginationCursor(), true) . '</pre>';
            exit;
        }

        $resp->setContent('Hello, friend');

        return $resp;
    }
}
