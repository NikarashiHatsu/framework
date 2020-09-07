<?php

namespace Shiroyuki\Web;

trait Session {
  /**
   * "All" session storage.
   * 
   * @var array $sessions
   */
  public $sessions = [];

  /**
   * Set the sessions.
   * 
   * @return void
   */
  public function __construct()
  {
    $this->boot();
  }

  /**
   * Return this class.
   * 
   * @return object
   */
  public function session()
  {
    return $this;
  }

  /**
   * Set initial session
   */
  private function boot()
  {
    $this->sessions = $_SESSION;
  }

  /**
   * The session data checker.
   * 
   * @param string $requested_data
   * @return bool
   */
  public function has($requested_data)
  {
    if(isset($this->session[$requested_data])) {
      return true;
    }
    
    return false;
  }

  /**
   * Get a session.
   * 
   * @param string $requested_data
   * @return string
   */
  public function get($requested_data)
  {
    return $this->sessions[$requested_data];
  }

  /**
   * Set a session
   * 
   * @param string|array
   * @return void|object
   */
  public function set(...$data)
  {
    $parsed = $data;
    
    // If the arguments passed are 'key', 'value'
    if(func_num_args() == 2) {
      $key = $parsed[0];
      $value = $parsed[1];

      $this->sessions[$key] = $value;
    } else {
      
      // If the arguments passed are 'array'
      if(is_array($parsed)) {
        $array = $parsed[0];
  
        foreach($array as $key => $value) {
          $this->sessions[$key] = $value;
        }
      }
    }

    return $this;
  }

  /**
   * Build the sessions
   */
  public function build()
  {
    foreach($this->sessions as $key => $item) {
      $_SESSION[$key] = $item;
    }

    return $this;
  }
}