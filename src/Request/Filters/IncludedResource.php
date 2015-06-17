<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/11/15
 * Time: 5:11 PM
 */

namespace Refinery29\Piston\Request\Filters;


use Refinery29\Piston\Request\Request;

class IncludedResource implements Filter
{
    /**
     * @param Request $request
     * @return Request
     */
    static public function apply(Request $request)
    {
        return $request;
    }

}