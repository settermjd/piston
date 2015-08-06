<?php namespace Refinery29\Piston\Router;

use Refinery29\Piston\Hooks\HasHooks;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\JsonResponse as Response;

trait HookProcessor
{
    /**
     * @param $item
     * @param $request
     * @param $original_response
     * @return Response
     */
    protected function processPreHooks(HasHooks $item, Request $request, Response $original_response)
    {
        $response = $item->getPreHooks()->process([$request, $original_response]);
        return $response instanceof Response ? $response : $original_response;
    }

    /**
     * @param $item
     * @param $request
     * @param $original_response
     * @return Response
     */
    protected function processPostHooks(HasHooks $item, Request $request, Response $original_response)
    {
        $response = $item->getPostHooks()->process([$request, $original_response]);
        return $response instanceof Response ? $response : $original_response;
    }
}
