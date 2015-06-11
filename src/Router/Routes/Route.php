<?php namespace Refinery29\Piston\Router\Routes;

use Refinery29\Piston\Hooks\Hookable;

/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/4/15
 * Time: 2:04 PM
 */

class Route
{
    use Hookable;

    protected $verb;
    protected $alias;
    protected $action;

    private $acceptable_verbs = ['POST', 'PUT', 'DELETE', 'GET'];

    public function __construct($verb, $alias, $action)
    {
        $this->validateVerb($verb);
        $this->verb = $verb;
        $this->alias = $alias;
        $this->action = $action;
    }

    static public function get($alias, $action)
    {
        return new static('GET', $alias, $action);
    }

    static public function post($alias, $action)
    {
        return new static('POST', $alias, $action);
    }

    static public function delete($alias, $action)
    {
        return new static('DELETE', $alias, $action);
    }

    static public function put($alias, $action)
    {
        return new static('PUT', $alias, $action);
    }

    private function validateVerb($verb)
    {
        if (!in_array($verb, $this->acceptable_verbs)) {
            throw new \InvalidArgumentException('Invalid Route Verb Supplied.');
        }
    }

    /**
     * @return mixed
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
}
