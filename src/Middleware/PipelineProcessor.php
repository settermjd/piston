<?php

namespace Refinery29\Piston\Middleware;

use Refinery29\Piston\Response;

abstract class PipelineProcessor
{
    /**
     * @param Subject $subject
     *
     * @return Response
     */
    public static function processPipeline(Subject $subject)
    {
        $response = $subject->getSubject()
            ->buildPipeline()
            ->process($subject);

        return $response instanceof Response ? $response : $subject->getResponse();
    }
}
