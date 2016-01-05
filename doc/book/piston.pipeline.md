# Pipelines

Piston provides a number of different points in the execution of the application pipeline which you can hook into to add extra functionality. This allows you to take action at different points, as you launch the app.

The hooks are applied in order from least specific (`Application`) to most specific (`RouteGroup`). Hook classes must implement `League\Pipeline\StageInterface` and define a `process()` method, which in turn must return an instance of `Refinery29\Piston\Http\Request`.

Pipelines exist at two levels:

- Application/Global level
- Route Group level

Hooks are, effectively, Middleware. If you’re not familiar with the term Middleware, think of it in terms of an onion. You have your basic application, which you can then wrap in layers of Middleware, each one providing a specific sevice, such as caching, logging, authentication, and so on.

The image below, kindly borrowed [from SitePoint](http://www.sitepoint.com/working-with-slim-middleware/), provides a good, visual, example of how Middleware works.

!["Middleware - Courtesy of SitePoint"](http://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2013/02/middleware.jpg)

## A Working Example

Let’s see how to refactor [the RouteGroup](./piston.route.group.md) code example in to a Pipeline hook.

> **Note:** Any classes referred to, which aren't contained below, you can find in that section of the documentation.

First, we’ll need to create a class which implements the `StageInterface` which we’ll call `UseTheForce`. The StageInterface requires the implementation of the method `process()`, which receives a variable called `$payload`, which is a `\Refinery29\Piston\Middleware\Payload`.

```php
<?php

namespace Refinery29\DummyPistonApp\Hooks;

use League\Pipeline\StageInterface;
use Refinery29\DummyPistonApp\Controller;
use Refinery29\Piston\Router\RouteGroup;
use Refinery29\Piston\Piston;

class UseTheForce implements StageInterface
{
    /**
     * @inheritdoc
     * @param \Refinery29\Piston\Middleware\Payload $payload
     */
    public function process($payload)
    {
        /** @var Piston $subject */
        $subject = $payload->getSubject();

        $subject->group('/jedi', function (RouteGroup $group) {
            $group->get(
                '/masters',
                Controller\JediController::class . '::getJediMasters'
            );
            $group->get(
                '/padawans',
                Controller\JediController::class . '::getJediPadawans'
            );
        });

        return $payload;
    }
}
```

In the process method, we’ll call `$payload`'s `getSubject()` method, which will return a `Piston` object. On there, we then call the `group()` method, setting up the route group, as we did previously. With that in place, we now need to add the middleware to Piston. So back in `index.php`, we’d do so by adding the following after the instantiation of our `Piston` object:

```php
// add the required classes
use Refinery29\DummyPistonApp\Hooks;

$hook = new UseTheForceHook();
$application->addMiddleware($hook);
```

