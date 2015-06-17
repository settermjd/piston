<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/11/15
 * Time: 12:35 PM
 */

namespace Refinery29\Piston\Request\Filters;

use Refinery29\Piston\Request\Request;

class Pagination implements Filter
{
    /**
     * @param Request $request
     * @return Request
     */
    static public function apply(Request $request)
    {
       $cursor = $request->get('cursor');

        return $request;
    }
}