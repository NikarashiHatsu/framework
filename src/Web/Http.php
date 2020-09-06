<?php

namespace Shiroyuki\Web;

class Http {
  /**
   * Set the response code
   * 
   * @param int $code
   * @return void
   */
  public function setResponseCode($code)
  {
     return http_response_code($code);
  }
}