<?php

namespace Shiroyuki\Web;

trait Session {
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
    echo json_encode($_SESSION);
    // if(count(self::$flashed) > 0) {
    //   echo "Yes";
    // } else {
    //   echo "No";
    // }
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
  public function set(...$data)
  {
    $parsed = $data;
    
    // If the arguments passed are 'key', 'value'
    if(func_num_args() == 2) {
      $key = $parsed[0];
      $value = $parsed[1];

      $_SESSION[$key] = $value;
    } else {
      
      // If the arguments passed are 'array'
      if(is_array($parsed)) {
        $array = $parsed[0];
  
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