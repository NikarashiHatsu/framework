<?php

namespace Shiroyuki\Web;

trait Session {
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
   * The session data checker.
   * 
   * @param string $requested_data
   * @return bool
   */
  public static function has($requested_data)
  {
    return (isset($_SESSION[$requested_data])) ? true : false;
  }

  /**
   * Get a session.
   * 
   * @param string $requested_data
   * @return string
   */
  public static function get($requested_data)
  {
    return $_SESSION[$requested_data];
  }

  /**
   * Show the data, then delete the data right away after it's shown.
   * 
   * @param string $requested_data
   * @return string
   */
  public static function flash($requested_data)
  {
    $session = $_SESSION[$requested_data];

    unset($_SESSION[$requested_data]);

    return $session;
  }

  /**
   * Set a session
   * 
   * @param string|array
   * @return void|object
   */
  public function set()
  {
    $data = func_get_args();
    
    // If the arguments passed are 'key', 'value'
    if(func_num_args() == 2) {
      $key = $data[0];
      $value = $data[1];

      $_SESSION[$key] = $value;
    } else {
      // If the arguments passed are 'array'
      if(is_array($data)) {
        $array = $data[0];
  
        foreach($array as $key => $value) {
          $_SESSION[$key] = $value;
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
    foreach($_SESSION as $key => $item) {
      $_SESSION[$key] = $item;
    }

    return $this;
  }
}