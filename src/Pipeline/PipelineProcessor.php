<?php namespace Refinery29\Piston\Pipeline;

use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;

trait PipelineProcessor
{
    /**
     * @param $item
     * @param $request
     * @param $original_response
     * @return Response
     */
    protected function processPrePipeline(HasPipelines $item, Request $request, Response $original_response)
    {
        $response = $item->getPrePipeline()->process([$request, $original_response]);

        if ($response instanceof Response) {
            return $response;
        }

        return $original_response;
    }

    /**
     * @param $item
     * @param $request
     * @param $original_response
     * @return Response
     */
    protected function processPostHooks(HasPipelines $item, Request $request, Response $original_response)
    {
        $response = $item->getPostPipeline()->process([$request, $original_response]);

        if ($response instanceof Response) {
            return $response;
        }

        return $original_response;
    }
}
