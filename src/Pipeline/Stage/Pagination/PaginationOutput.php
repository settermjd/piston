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
        $pagination = ', "pagination" : ' . json_encode(['offset' => $offsetLimit['offset'], 'limit' => $offsetLimit['limit']]);

        return $content . $pagination;
    }

    private function buildCursorOutput($content, array $cursors)
    {
        $pagination = ', "pagination" : ' . json_encode(['prev' => $cursors['prev'], 'next' => $cursors['next']]);

        return $content . $pagination;
    }
}
