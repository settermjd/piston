<?php

namespace Refinery29\Piston\Pipeline\Stage\Pagination;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Http\JsonResponse;

class PaginationOutput implements StageInterface
{

    /**
     * Process the payload.
     *
     * @param JsonResponse $payload
     *
     * @return mixed
     */
    public function process($payload)
    {
        $content = $payload->getContent();

        $offsetLimit = $payload->getOffsetLimit();

        if ($offsetLimit) {
            $content = $this->buildOffsetLimitOutput($content, $offsetLimit);
        }

        $cursors = $payload->getPaginationCursors();

        if ($cursors) {
            $content = $this->buildCursorOutput($content, $cursors);
        }

        $payload->setContent($content);

        return $payload;
    }

    private function buildOffsetLimitOutput($content, $offsetLimit)
    {
        $output = '    "pagination": {
        "offset": '.array_shift($offsetLimit).',
        "limit": '.array_shift($offsetLimit).'
        }';

        return $content . $output;
    }

    private function buildCursorOutput($content, $cursors)
    {
        $output = '    "pagination": {
        "prev": '.array_shift($cursors).',
        "next": '.array_shift($cursors).'
        }';

        return $content . $output;
    }
}