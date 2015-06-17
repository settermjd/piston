<?php namespace Refinery29\Piston\Hooks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/17/15
 * Time: 2:59 PM
 */

interface Hook
{
    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function apply(Request $request, Response $response);
}