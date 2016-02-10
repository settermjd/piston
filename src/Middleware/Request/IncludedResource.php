<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Piston\Middleware\Request;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Middleware\GetOnlyStage;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Request;

class IncludedResource implements StageInterface
{
    use GetOnlyStage;

    /**
     * @param Payload $payload
     *
     * @throws \League\Route\Http\Exception\BadRequestException
     *
     * @return Request
     */
    public function process($payload)
    {
        /** @var Request $request */
        $request = $payload->getRequest();

        if (!isset($request->getQueryParams()['include'])) {
            return $payload;
        }

        $this->ensureGetOnlyRequest($request);

        $include = explode(',', $request->getQueryParams()['include']);

        if (!empty($include)) {
            foreach ((array) $include as $k => $resource) {
                if (strpos($resource, '.') !== false) {
                    $resource = explode('.', $resource);

                    $include[$k] = $resource;
                }
            }

            //$request->setIncludedResources($include);
            $payload->withRequest($request->withIncludedResources($include));
        }

        return $payload;
    }
}
