<?php namespace Refinery29\Piston\Router\Routes;

use Refinery29\Piston\Hooks\Hookable;

class Route
{
    use Hookable;

    /**
     * @var
     */
    protected $verb;

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $action;

    /**
     * @var array
     */
    private $acceptable_verbs = ['POST', 'PUT', 'DELETE', 'GET'];

    /**
     * @param $verb
     * @param $url
     * @param $action
     */
    public function __construct($verb, $url, $action)
    {
        $this->validateVerb($verb);
        $this->action = $action;
        $this->url = $url;
    }

    /**
     * @param $verb
     */
    private function validateVerb($verb)
    {
        if (!in_array($verb, $this->acceptable_verbs)) {
            throw new \InvalidArgumentException('Invalid Route Verb Supplied.');
        }

        $this->verb = $verb;
    }

    /**
     * @param $url
     * @param $action
     * @return static
     */
    public static function get($url, $action)
    {
        return new static('GET', $url, $action);
    }

    /**
     * @param $url
     * @param $action
     * @return static
     */
    public static function post($url, $action)
    {
        return new static('POST', $url, $action);
    }

    /**
     * @param $url
     * @param $action
     * @return static
     */
    public static function delete($url, $action)
    {
        return new static('DELETE', $url, $action);
    }

    /**
     * @param $url
     * @param $action
     * @return static
     */
    public static function put($url, $action)
    {
        return new static('PUT', $url, $action);
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
    public function getUrl()
    {
        return $this->url;
    }

    public function updateUrl($segment)
    {
        $segment = trim($segment, "/");
        $this->url = $segment."/". $this->url;

        $this->url = str_replace('//', '/', $this->url);
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
}
