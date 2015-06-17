<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/11/15
 * Time: 12:35 PM
 */

namespace Refinery29\Piston\Hooks\QueryString;


use Refinery29\Piston\Hooks\Hook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePaginationHook extends QueryStringHook implements Hook
{
    public function apply(Request $request, Response $response)
    {
        $this->parseRequest();
        $qs = $request->getQueryString();
        echo "<pre>".print_r($qs, true)."</pre>"; exit;
    }
}