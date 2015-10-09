<?php

namespace Refinery29\Piston\Middleware;

class PipelineProcessor
{
    /**
     * @param Payload $subject
     *
     * @return Payload
     */
    public function handleSubject(Payload $subject)
    {
        return $subject->getSubject()
            ->buildPipeline()
            ->process($subject);
    }
}
