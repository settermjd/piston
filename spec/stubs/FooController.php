<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Piston\Stubs;

use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Zend\Diactoros\Response\HtmlResponse;

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

    public function testHTMLResponse()
    {
        return new HTMLResponse('<p>Hello World</p>');
    }
}
