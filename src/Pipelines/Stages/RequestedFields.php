<?php namespace Refinery29\Piston\Pipelines\Stages;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Http\Request;

/**
 * Class Fields
 * @package Refinery29\Piston\Request\Filters
 */
class RequestedFields implements StageInterface
{
    use GetOnlyStage;
    /**
     * @param Request $request
     * @return Request
     */
    public function process($request)
    {
        $fields = $request->get('fields');

        if ($fields) {
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
