<?php
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/11/15
 * Time: 5:11 PM
 */

namespace Refinery29\Piston\Request\Filters;

use Refinery29\Piston\Request\Request;

class Fields implements Filter
{
    static public function apply(Request $request)
    {
        $fields = $request->get('fields');
        $fields = explode(',', $fields);

        $request->setRequestedFields($fields);

        return $request;
    }

}