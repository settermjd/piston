<?php namespace Refinery29\Piston\Router;

trait HookProcessor
{
    /**
     * @param $item
     * @param $request
     * @param $original_response
     * @return Response
     */
    protected function processPreHooks($item, $request, $original_response)
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
    protected function processPostHooks(Hookable $item, $request, $original_response)
    {
        $response = $item->getPostHooks()->process([$request, $original_response]);
        return $response instanceof Response ? $response : $original_response;
    }
}
