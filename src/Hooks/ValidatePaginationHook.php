<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/11/15
 * Time: 12:35 PM
 */

namespace Refinery29\Piston\Hooks;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePaginationHook implements Hook
{
    public function apply(Request $request, Response $response)
    {
        $qs = $request->getQueryString();
        echo "<pre>".print_r($qs, true)."</pre>"; exit;
    }
}