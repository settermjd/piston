<?php

namespace Refinery29\Piston\Pipeline;

use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;

trait PipelineProcessor
{
    /**
     * @param $item
     * @param $request
     * @param $original_response
     *
     * @return Response
     */
    protected function processPipeline(HasPipeline $item, Request $request, Response $original_response)
    {
        $response = $item->getPipeline()->process([$request, $original_response]);

        return $response instanceof Response ? $response : $original_response;
    }
}
