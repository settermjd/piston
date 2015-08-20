<?php

namespace Refinery29\Piston\Pipeline;

use Refinery29\Piston\Http\JsonResponse as Response;
use Refinery29\Piston\Http\Request;

trait PipelineProcessor
{
    /**
     * @param $item
     * @param $request
     * @param $original_response
     *
     * @return Response
     */
    protected function processPrePipeline(HasPipelines $item, Request $request, Response $original_response)
    {
        $response = $item->getPrePipeline()->process([$request, $original_response]);

        return $response instanceof Response ? $response : $original_response;
    }

    /**
     * @param $item
     * @param $request
     * @param $original_response
     *
     * @return Response
     */
    protected function processPostPipeline(HasPipelines $item, Request $request, Response $original_response)
    {
        $response = $item->getPostPipeline()->process([$request, $original_response]);

        return $response instanceof Response ? $response : $original_response;
    }
}
