<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/17/15
 * Time: 3:03 PM
 */

namespace Refinery29\Piston\Request\Filters;


use Refinery29\Piston\Request\Request;

interface Filter {

    /**
     * @param Request $request
     * @return Request
     */
    static public function apply(Request $request);
}