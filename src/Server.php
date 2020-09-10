<?php

namespace Shiroyuki;

use Shiroyuki\Server\Variables;

class Server {
  /**
   * Use all traits
   */
  use Variables;

  /**
   * Get the REQUEST_URI 
   * 
   * @return string
   */
  public static function getUri()
  {
    return $_SERVER["REQUEST_URI"];
  }
}