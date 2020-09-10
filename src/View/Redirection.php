<?php

namespace Shiroyuki\View;

use Shiroyuki\Web\Session;

trait Redirection {
  /**
   * Use all trait
   */
  use Session;

  /**
   * The destined page.
   * 
   * @var string
   */
  public $destination;

  /**
   * The optional message.
   * 
   * @var array
   */
  public $message;

  /**
   * Redirect the page into the destined page.
   * 
   * @param string $page
   * @return string|object $this;
   */
  public function redirect($page = "")
  {
    if($page != "") {
      return $this->destination = $page;
    }
    
    // Wait for the next command
    return $this;
  }

  /**
   * Redirect to the previous page.
   * 
   * @return object
   */
  public function back()
  {
    $this->destination = "back";

    return $this;
  }

  /**
   * Set the certain message.
   * 
   * @param array $message
   * @return object
   */
  public function with()
  {
    $message = func_get_args();

    if(func_num_args() == 2) {
      return $this->set($message[0], $message[1]);
    }

    return $this->set($message[0]);
  }

  /**
   * Deconstruct the class
   * 
   * @return void|object
   */
  public function __destruct()
  {
    if(is_array($this->message)) {
      $this->set($this->message);
    }

    $this->session()->build();

    if($this->destination == "back") {
      echo "<script>window.history.back()</script>";
    }

    // The other "destination" will be implemented soon.
  }
}