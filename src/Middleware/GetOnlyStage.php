<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Piston\Middleware;

use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Request;

trait GetOnlyStage
{
    /**
     * @param Request $request
     *
     * @throws BadRequestException
     */
    public function ensureGetOnlyRequest(Request $request)
    {
        if ($request->getMethod() !== 'GET') {
            throw new BadRequestException('Query parameter is only allowed on GET requests');
        }
    }
}
