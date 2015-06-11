<?php namespace Refinery29\Piston\Stubs;

use Refinery29\Piston\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/9/15
 * Time: 4:39 PM
 */

class FooController extends Controller
{
    function fooAction(Request $req, Response $resp)
    {
        $resp->setContent('Hello World');
        return $resp;
    }
}