# Piston
Micro Framework for APIs


## Routing

### Controller Based Routing

```
$application = new Application();

$application->AddRoute(Route::get('jedi/{id}', 'JediController::useTheForce'));

```

### Closure Based Routing

```
$application = new Application();

$application->AddRoute(Route::get('jedi/{id}', 'JediController::useTheForce'));

```