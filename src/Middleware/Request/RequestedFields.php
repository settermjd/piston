<?php

namespace Refinery29\Piston\Middleware\Request;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Middleware\GetOnlyStage;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Request;

/**
 * Class Fields
 */
class RequestedFields implements StageInterface
{
    use GetOnlyStage;

    /**
     * @param Payload $payload
     *
     * @return Payload
     */
    public function process($payload)
    {
        /** @var Request $request */
        $request = $payload->getRequest();

        if (!isset($request->getQueryParams()['fields'])) {
            return $payload;
        }

        $fields = $request->getQueryParams()['fields'];

        if ($fields) {
            $this->ensureGetOnlyRequest($request);
            $fields = explode(',', $fields);
        }

        if (!empty($fields)) {
            $request->setRequestedFields((array) $fields);
        }

        return $payload;
    }
}
