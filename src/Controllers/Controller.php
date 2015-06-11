<?php namespace Refinery29\Piston\Controllers;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/4/15
 * Time: 1:51 PM
 */

class Controller
{
    public function notFound()
    {
        return new Response('', 404);
    }

    public function redirect($url)
    {
        return new RedirectResponse($url);
    }
}