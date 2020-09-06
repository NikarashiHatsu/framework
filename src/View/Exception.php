<?php

namespace Shiroyuki\View;

use Shiroyuki\Web\Http;
use Shiroyuki\View\View;

class Exception {
  /**
   * Throw the error. The default method settings has no view at all. You can
   * throw the view using the same way as the routing. For example 
   * abort(404, 'errors.404').
   * 
   * @param int $code
   * @param string $view
   * @return void
   */
  public function abort($code, $page = '')
  {
    $http = new Http;
    $http->setResponseCode($code);

    if($page != '') {
      $view = new View;
      $view->view($page);
    }

    switch ($code) {
      case 400:
        die("Bad Request");
        break;

      case 401:
        die("Unauthorized");
        break;

      case 402:
        die("Payment Required");
        break;

      case 403:
        die("Forbidden");
        break;

      case 404:
        die("Page Not Found");
        break;

      case 405:
        die("Method Not Allowed");
        break;
      
      case 500:
        die("Internal Server Error");
        break;

      case 501:
        die("Not Implemented");
        break;

      case 502:
        die("Bad Gateway");
        break;

      case 503:
        die("Service Unavailable");
        break;

      case 504:
        die("Gateway Timeout");
        break;
        
      default:
    }
  }
}