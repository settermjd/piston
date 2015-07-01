# Piston
Opinionated Micro Framework for APIs

-[![Build Status](https://travis-ci.org/refinery29/piston.svg?branch=master)](https://travis-ci.org/refinery29/piston) [![Code Climate](https://codeclimate.com/github/refinery29/piston/badges/gpa.svg)](https://codeclimate.com/github/refinery29/piston) [![Test Coveragex](https://codeclimate.com/github/refinery29/piston/badges/coverage.svg)](https://codeclimate.com/github/refinery29/piston/coverage)

## Routing

Piston supports route based and closure based routing. In both cases, the action must return an instance of `Refinery29\Piston\Http\Request`. Routes are implemented as simple value objects that hold url alias, http verb, and action. 

**Route Based**
```
$application = new Application();
$application->addRoute(Route::get('jedi/{id}', 'JediController::useTheForce'));
```

**Closure Based**
```
$application = new Application();
$application->AddRoute(Route::get('jedi/{id}', function($request, $response(){
	return $response;
});
```

Piston relies on [`league/route`](http://route.thephpleague.com/) for routing. This allows for parameterized routes such as `/jedi/master/{name}`. You are able to enforce that the parameters be either a number of a word: `{id:number}/{name:word}`

### Route Groups
There is also the ability to create Route groups that can bundle certain routes together. For instance, if you have a set of routes that are Admin accessible, you can create a group for those routes. 

```
$application = new Application();

$route1 = Route::get('jedi/{id}', 'JediController::useTheForce'));
$route2 = Route::get('sith/{id}', 'SithController::useTheForce'));

$group = new RouteGroup();
$group->addRoute($route1);
$group->addRoute($route2);

$application->addRouteGroup($group);
```

You can also use the convenience function `group()`. 

```
$application->group($route1, $route2, $route2);
```

### Hooks
Piston provides another of different hookable points in the execute of the application. This allows you to take action at different points, as you launch the app. 

Pre and Post Hooks are provided for each of these objects:   
- Application   
- Route Group  
- Route   

Hooks are applied in order from least specific to most specific. Application, then RouteGroup, then Route. 

Hooks must implement `League\Pipeline\StageInterface` and define a `process()` method which must return an instance of `Refinery29\Piston\Http\Request`

```
$hook = new UseTheForceHook();
$application->addPreHook($hook);
```

### Service Providers
Service providers can be easily added to encapsulate any service necessary to the application. 

```
$application = new Piston();
$application->register(new LightSaberProvider());
```

### Query Parameters
Piston is an api focused framework, and therefore encapsulates a number of different query parameter options. 

**Fields**  
Specific fields can be requested of the application, with the purpose of only returning those fields. Fields are specified as a comma separated list.

`url.com?fields=jedi,sith,yoda`

The above URL is automatically parsed, and you are able to retrieve that information as follows: 

`$request->getRequestedFields();`

You can determine if the request has requested fields: 
`$request->hasRequestedFields()`

**Pagination**  
Piston currently supports only cursor based pagination. 

`url.com?before=124ksl&after=0809asdj`
These parameters are available on the request as follows:  

`$request->getPaginationCursor()`  

This function returns an array with the keys `before` and `after`

You can determine if the request is paginated: 
`$request->isPaginated()`

**Included Resources**    
You may also request different relations be included in the response. 

`url.com?include=master,padawan,planet`

These parameters will be available:
`$request->getIncludedResources()` which will return an array of requested relations.

*Nested Relations*    
You are also able to request nested resources. 

`url.com?include=jedi.master.padawan,planet`

These parameters are accessed in the same way as single level relations, however the result is different:

```
array 
	[0] => array 
   				[0] => jedi
   				[1] => master
   				[2] => padawan
   	[1] => planet
```


All of the above filters are only allowed on `GET` requests. Use of any of these parameters will result in an error if used with any other HTTP verb.

### Configuration
You are able to pass in configuration variables via the following method:  

```
$config = [
    'super_secret_key' => 'super_secret_value'
]

$application = new Piston();
$application->setConfig($config);
```

Configuration is available through: 

```
$app->getConfig()
```

### Todo:
- [ ] CSRF Protection on POST and PUT routes
- [ ] Offset/limit and page based pagination
