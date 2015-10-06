<?php

namespace Refinery29\Piston\Middleware;

use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;

class PipelineProcessor
{
    /**
     * @param $item
     * @param $request
     * @param $original_response
     *
     * @return Response
     */
    public function processPipeline(Subject $subject)
    {
        $response = $subject->getSubject()
            ->buildPipeline()
            ->process($subject);

        return $response instanceof Response ? $response : $subject->getResponse();
    }
}
