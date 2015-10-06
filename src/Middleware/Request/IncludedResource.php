<?php

namespace Refinery29\Piston\Middleware\Request;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Middleware\GetOnlyStage;
use Refinery29\Piston\Request;

class IncludedResource implements StageInterface
{
    use GetOnlyStage;

    /**
     * @param Subject $payload
     *
     * @return Request
     * @throws \League\Route\Http\Exception\BadRequestException
     *
     */
    public function process($payload)
    {
        /** @var Request $request */
        $request = $payload->getSubject();

        $this->ensureGetOnlyRequest($request);

        if (!isset($request->getQueryParams()['include'])) {
            return $payload;
        }

        $include = explode(',', $request->getQueryParams()['include']);


        if (!empty($include)) {
            foreach ((array) $include as $k => $resource) {
                if (strpos($resource, '.') !== false) {
                    $resource = explode('.', $resource);

                    $include[$k] = $resource;
                }
            }

            $request->setIncludedResources($include);
        }
        return $payload;
    }
}
