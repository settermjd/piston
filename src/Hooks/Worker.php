<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/16/15
 * Time: 12:25 PM
 */

namespace Refinery29\Piston\Hooks;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Worker
{
    /**
     * @param Queue $queue
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    static public function work(Queue $queue, Request $request, Response $response)
    {
        foreach ($queue->getHooks() as $hook)
        {
            $response = $hook->apply($request, $response);
        }

        return $response;
    }
}