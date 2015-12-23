# Route Groups

Route groups provide the ability to bundle routes together. Let’s say that you want to build a series of routes about the Jedi, routes which will all be prefixed, automatically, by `/jedi`. To do so, a route group is the best way to go about it.

Building on the previous example, if we wanted to handle the routes `/jedi/masters/` and `/jedi/padawans`, we’d first add the methods `getJediMasters()` and  `getJediPadawans()` to the `JediController` class, defined as follows:

```php
public function getJediMasters(Request $request, Response $response)
{
    $response = $response->setStatusCode(200);
    $response->setResult(ResourceFactory::result([
        'Yoda', 'Ki-Adi-Mundi', 'Mace Windu',
        'Plo Koon', 'Saesee Tiin', 'Yaddle', 'Even Piell'
    ]));

    return $response;
}

public function getJediPadawans(Request $request, Response $response)
{
    $response = $response->setStatusCode(200);
    $response->setResult(ResourceFactory::result([
        'Ahsoka Tano', 'Kanan Jarrus'
    ]));

    return $response;
}
```

With these added, we can now setup the new route group. This requires two things; the route group and the routes within the group.

```php
// include the RouteGroup class
use Refinery29\Piston\Router\RouteGroup;

$routeGroup = $application->group('/jedi', function (RouteGroup $group) {
    $group->get('/masters', Controller\JediController::class . '::getJediMasters');
    $group->get('/padawans’, Controller\JediController::class . '::getJediPadawans');
});
```

Here we've setup the route group which will have the prefix `/jedi` and within that group, added two sub-routes, both of which support `GET` requests and are handled by the `JediController` methods which we just created.
