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
   * Add route to GET header list.
   * 
   * @param string $route
   * @param string $controller
   * @return void
   */
  public function get($route, $controller)
  {
    array_push($this->httpRoutes['GET'], [$route => $controller]);
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
    array_push($this->httpRoutes['POST'], [$route => $controller]);
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
    array_push($this->httpRoutes['PUT'], [$route => $controller]);
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
    array_push($this->httpRoutes['DELETE'], [$route => $controller]);
  }

  /**
   * Use up the controller
   * 
   * @param string $controller
   * @return void
   */
  public function useController($controller)
  {
    $real_controller = explode('@', $controller);
    
    $class = '\App\Controller\\' . $real_controller[0];
    $method = $real_controller[1];
    
    $object = new $class();
    $object->$method();
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
    $uri = $this->requestUri;
    $supported_request = ['GET', 'POST', 'PUT', 'DELETE'];
    $routes = $this->httpRoutes;

    for($i = 0; $i < count($routes); $i++) {
      $the_route = $routes[$supported_request[$i]];
      
      for($j = 0; $j < count($the_route); $j++) {
        if(array_key_exists($uri, $the_route[$j])) {
          if($supported_request[$i] == $this->requestMethod) {
            return $this->useController($the_route[$j][$uri]);
          } else {
            return $this->throwAbort(405);
          }
        }
      }
    }
    
    $this->throwAbort(404);
  }
}