<?php

namespace Shiroyuki\Web;

class Request {
  /**
   * The data taken from the inputs.
   * 
   * @var array
   */
  public $request;

  /**
   * Put the form data into $request.
   * 
   * @return void
   */
  public function __construct()
  {
    foreach($_REQUEST as $key => $value) {
      $t_key = $key;
      $t_value = $value;

      $this->$t_key = $t_value;
    }
  }
}