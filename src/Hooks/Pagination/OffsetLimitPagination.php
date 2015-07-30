<?php namespace Refinery29\Piston\Hooks\Pagination;

use League\Route\Http\Exception\BadRequestException;
use Refinery29\Piston\Http\Request;

class OffsetLimitPagination extends PaginationHook
{
    protected $default_offset = 0;

    protected $default_limit = 10;

    /**
     * @param Request $request
     * @throws BadRequestException
     * @return Request
     */
    public function process($request)
    {
        parent::process($request);

        $offset = $this->coerce($request->get('offset'), 'offset') ?: $this->default_offset;
        $limit = $this->coerce($request->get('limit'), 'limit') ?: $this->default_limit;

        $request->setOffsetLimit($offset, $limit);

        return $request;
    }

    /**
     * @param mixed $param
     * @param string $param_name
     * @throws BadRequestException
     * @return int
     */
    private function coerce($param, $param_name)
    {
        if (!$param) {
            return;
        }

        if (is_numeric($param)) {
            $coerced = intval($param);
            if ($coerced == floatval($param)) {
                return $coerced;
            }
        }

        throw new BadRequestException('Parameter "' . $param_name . '" must be an integer. Got ' . $param);
    }
}
