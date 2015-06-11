<?php namespace Refinery29\Piston\Router\Routes;
/**
 * Created by PhpStorm.
 * User: kayla.daniels
 * Date: 6/4/15
 * Time: 2:04 PM
 */

class Route
{
    protected $verb;
    protected $alias;
    protected $action;
    protected $permission;

    private $acceptable_verbs = ['POST', 'PUT', 'DELETE', 'GET'];

    public function __construct($verb, $alias, $action, $permission = NULL)
    {
        $this->validateVerb($verb);
        $this->verb = $verb;
        $this->alias = $alias;
        $this->action = $action;
        $this->permission = $permission;
    }

    static public function get($alias, $action, $permission = NULL)
    {
        return new static('GET', $alias, $action, $permission);
    }

    static public function post($alias, $action, $permission = NULL)
    {
        return new static('POST', $alias, $action, $permission);
    }

    static public function delete($alias, $action, $permission = NULL)
    {
        return new static('DELETE', $alias, $action, $permission);
    }

    static public function put($alias, $action, $permission = NULL)
    {
        return new static('PUT', $alias, $action, $permission);
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

    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission)
    {
        if (!is_null($this->permission)){
            throw new \Exception('you cannot change permission once set');
        }
        $this->permission = $permission;
    }
}
