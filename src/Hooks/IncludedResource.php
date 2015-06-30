<?php namespace Refinery29\Piston\Hooks;

use League\Pipeline\OperationInterface;
use Refinery29\Piston\Request;

class IncludedResource extends GetOnlyHook implements OperationInterface
{
    /**
     * @param Request $request
     * @return Request
     */
    public function process($request)
    {
        $include = $request->get('include');

        if (($include)) {
            $this->ensureGetOnlyRequest($request);
        }

        if ($include) {
            $include = explode(',', $include);
        }

        foreach ((array)$include as $k => $resource) {
            if (strpos($resource, '.') !== false) {
                $resource = explode('.', $resource);

                $include[$k] = $resource;
            }
        }

        if (!empty($include)) {
            $request->setIncludedResources($include);
        }

        return $request;
    }
}
