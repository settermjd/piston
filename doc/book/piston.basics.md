# Piston Basics

Piston is an opinionated Micro Framework for APIs.

Let’s look a bit closer at what’s happening. A route for GET requests to `/` is added onto the route stack, to be handled by the `JediController`'s `renderHomePage()` method.

When requests are made to the application, if a request is made to that route, then JediController will be instantiated and have its renderHomePage() method called, passing to it the request and response objects, which were generated based on the current request.

Any requests to routes not in the routing table will go one of two ways. If the route’s not found, a `NotFoundException` will be thrown, which, internally, constructs and returns a  response object with an [HTTP 404](http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.5) status.

If a valid route was requested, but with a method which has not been allowed for that route, then a `MethodNotAllowedException` will be thrown, which,internally constructs and returns a response with an [HTTP 405 status](http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.6).
