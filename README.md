# Piston

[![Build Status](https://travis-ci.org/refinery29/piston.svg?branch=master)](https://travis-ci.org/refinery29/piston) [![Code Climate](https://codeclimate.com/github/refinery29/piston/badges/gpa.svg)](https://codeclimate.com/github/refinery29/piston)[![Test Coveragex](https://codeclimate.com/github/refinery29/piston/badges/coverage.svg)](https://codeclimate.com/github/refinery29/piston/coverage)

Micro Framework for APIs

## Currently Under Development
Highly in flux and not for use in production. 

## Routing

### Controller Based Routing

```
$application = new Piston();

$application->addRoute(Route::get('jedi/{id}', 'JediController::useTheForce'));

```

### Closure Based Routing

```
$application = new Piston();

$application->addRoute(Route::get('jedi/{id}', function(Request $request, Response $response)
{
    //do some cool stuff here
    return $response;
}));

```
