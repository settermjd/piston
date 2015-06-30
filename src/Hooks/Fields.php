<?php namespace Refinery29\Piston\Hooks;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Http\Request;

/**
 * Class Fields
 * @package Refinery29\Piston\Request\Filters
 */
class Fields extends GetOnlyHook implements StageInterface
{
    /**
     * @param Request $request
     * @return Request
     */
    public function process($request)
    {
        $fields = $request->get('fields');

        if (($fields)) {
            $this->ensureGetOnlyRequest($request);
        }

        if ($fields) {
            $fields = explode(',', $fields);
        }

        if (!empty($fields)) {
            $request->setRequestedFields((array)$fields);
        }

        return $request;
    }
}
