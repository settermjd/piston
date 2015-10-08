<?php

namespace Refinery29\Piston\Middleware\Pagination;

use League\Pipeline\StageInterface;
use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Middleware\GetOnlyStage;
use Refinery29\Piston\Request;

class OffsetLimitPagination implements StageInterface
{
    use SinglePagination;
    use GetOnlyStage;

    /**
     * @var int
     */
    protected $default_offset = 0;

    /**
     * @var int
     */
    protected $default_limit = 10;

    /**
     * @param Request $request
     *
     * @throws BadRequestException
     *
     * @return Request
     */
    public function process($request)
    {
        $this->ensureNotPreviouslyPaginated($request);

        $offset = $this->coerceToInteger($request->get('offset'), 'offset');
        $limit = $this->coerceToInteger($request->get('limit'), 'limit');

        if ($offset || $limit) {
            $this->ensureGetOnlyRequest($request);

            $offset = $offset ?: $this->default_offset;
            $limit = $limit ?: $this->default_limit;
            $request->setOffsetLimit($offset, $limit);
        }

        return $request;
    }

    /**
     * @param mixed  $param
     * @param string $param_name
     *
     * @throws BadRequestException
     *
     * @return int
     */
    private function coerceToInteger($param, $param_name)
    {
        if (!$param) {
            return;
        }

        if (is_numeric($param)) {
            $integer_value = intval($param);

            if ($integer_value == floatval($param)) {
                return $integer_value;
            }
        }

        throw new BadRequestException('Parameter "' . $param_name . '" must be an integer. Got ' . $param);
    }
}
