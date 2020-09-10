<?php

namespace Shiroyuki\Routes;

use Shiroyuki\Routes\RouteList;
use Shiroyuki\Server\Variables;
use Shiroyuki\View\Exception;

class Route {
  /**
   * Use all traits
   */
  use Variables,
      RouteList;
  
  /**
   * Construct function
   */
  public function __construct()
  {
    $this->setVariables();
  }

  /**
   * Fetch the route's arguments
   */
  private function fetch_route_args($route)
  {
    $arguments = [];
    
    // Fetch all the possible routing
    preg_match_all('/\/[a-z]\w+|\/[\{a-z]\w+\}/', $route, $possible_routes);

    // Search for the position of the argument
    foreach($possible_routes[0] as $key => $item) {
      if(preg_match('/\/[\{a-z]\w+\}/', $item)) {
        array_push($arguments, ['position' => $key, 'argument' => $item]);
      }
    }

    return $arguments;
  }

  /**
   * Add route to GET header list.
   * 
   * @param string $route
   * @param string $controller
   * @return void
   */
  public function get($route, $controller)
  {
    $args = $this->fetch_route_args($route);

    array_push($this->httpRoutes, [
      'request_method' => 'GET', 
      'route' => $route,
      'controller' => $controller,
      'args' => $args
    ]);
  }

  /**
   * Add route to POST header list.
   * 
   * @param string $route
   * @param string $controller
   * @return void
   */
  public function post($route, $controller)
  {
    $args = $this->fetch_route_args($route);
    
    array_push($this->httpRoutes, [
      'request_method' => 'POST', 
      'route' => $route,
      'controller' => $controller,
      'args' => $args
    ]);
  }

  /**
   * Add route to PUT header list.
   * 
   * @param string $route
   * @param string $controller
   * @return void
   */
  public function put($route, $controller)
  {
    $args = $this->fetch_route_args($route);
    
    array_push($this->httpRoutes, [
      'request_method' => 'PUT', 
      'route' => $route,
      'controller' => $controller,
      'args' => $args
    ]);
  }

  /**
   * Add route to DELETE header list.
   * 
   * @param string $route
   * @param string $controller
   * @return void
   */
  public function delete($route, $controller)
  {
    $args = $this->fetch_route_args($route);
    
    array_push($this->httpRoutes, [
      'request_method' => 'DELETE', 
      'route' => $route,
      'controller' => $controller,
      'args' => $args
    ]);
  }

  /**
   * Use up the controller
   * 
   * @param string $controller
   * @param mixed|null $args
   * @return void
   */
  public function useController()
  {
    $args = func_get_args();
    
    // First args is always used as Controller
    $controller = $args[0];
    $real_controller = explode('@', $controller);
    
    // Other args
    $other_args = [];
    for($i = 1; $i < count($args); $i++) {
      array_push($other_args, $args[$i]);
    }

    $class = '\App\Controller\\' . $real_controller[0];
    $object = new $class();
    $method = $real_controller[1];
    
    if(is_array($other_args)) {
      if(count($other_args) > 0) {
        $object->$method($other_args[0]);
      } else {
        $object->$method();
      }
    }
  }

  /**
   * Throw the abort function from Shiroyuki\View\Exception
   * 
   * @param $code
   * @return void
   */
  public function throwAbort($code)
  {
    $exception = new Exception;
    $exception->abort($code);
  }

  /**
   * Create the url based on the server's name and the URI requested.
   * 
   * @param string $uri
   * @return string $result
   */
  public function url($uri)
  {
    $var = new Variables;
    $server = $var->serverName;

    $url = $server . '/' . $uri;

    return $url;
  }

  /**
   * Destruct function
   * 
   * @return void
   */
  public function __destruct()
  {
    $uri = ($this->requestUri != '/' ? rtrim($this->requestUri, '/') : $this->requestUri);
    $valid_routes = [];
    $invalid_routes = [];

    // Set the valid routes
    foreach($this->httpRoutes as $route) {
      if($this->requestMethod === $route['request_method']) {
        array_push($valid_routes, $route);
      } else {
        array_push($invalid_routes, $route);
      }
    }

    // Single leveled
    foreach($invalid_routes as $route) {
      if($uri === $route['route']) {
        return $this->throwAbort(405);
      }
    }

    // Check the invalid routes first
    foreach($invalid_routes as $route) {
      // Multi leveled
      if($uri !== '/') {
        $args = $route['args'];
        $exploded_uri = explode('/', trim($uri, '/'));
        $exploded_route = explode('/', trim($route['route'], '/'));

        foreach($args as $arg) {
          preg_match('/(\{[a-z]\w+\})/', $exploded_route[$arg['position']], $regd_route);
          if(count($regd_route) > 0) {
            $exploded_route[$arg['position']] = '/(.*)';
            $exploded_uri[$arg['position']] = '/(.*)';
          }
        }
  
        $imploded_uri = implode('/', $exploded_uri);
        $imploded_route = implode('/', $exploded_route);
  
        if($imploded_uri === $imploded_route) {
          // Pass the delete
          return $this->throwAbort(405);
        }
      }
    }

    // Single leveled
    foreach($valid_routes as $route) {
      if($uri === $route['route']) {
        return $this->useController($route['controller']);
      }
    }

    // Check the valid routes
    foreach($valid_routes as $route) {
      // Multi leveled
      if($uri !== '/') {
        $args = $route['args'];
        $exploded_uri = explode('/', trim($uri, '/'));
        $exploded_route = explode('/', trim($route['route'], '/'));
        $args_to_pass = [];

        foreach($args as $arg) {
          preg_match('/(\{[a-z]\w+\})/', $exploded_route[$arg['position']], $regd_route);
          if(count($regd_route) > 0) {
            array_push($args_to_pass, $exploded_uri[$arg['position']]);

            $exploded_route[$arg['position']] = '/(.*)';
            $exploded_uri[$arg['position']] = '/(.*)';
          }
        }
  
        $imploded_uri = implode('/', $exploded_uri);
        $imploded_route = implode('/', $exploded_route);
  
        if($imploded_uri === $imploded_route) {
          if(count($args_to_pass) > 0) {
            return $this->useController($route['controller'], $args_to_pass);
          }
        }
      }
    }

    $this->throwAbort(404);
  }
}