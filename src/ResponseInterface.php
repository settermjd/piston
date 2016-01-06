<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Piston;

use Refinery29\ApiOutput\Resource\Error\ErrorCollection;
use Refinery29\ApiOutput\Resource\Pagination\Pagination;
use Refinery29\ApiOutput\Resource\Result;

interface ResponseInterface
{
    /**
     * @param Pagination $pagination
     */
    public function setPagination(Pagination $pagination);

    /**
     * @param ErrorCollection $error
     */
    public function setErrors(ErrorCollection $error);

    /**
     * @param Result $result
     */
    public function setResult(Result $result);

    /**
     * @param int $code
     */
    public function setStatusCode($code);

    /**
     * @return mixed
     */
    public function send();
}
