<?php

namespace Shiroyuki;

class Hash {
  /**
   * Hash the password.
   * 
   * @param string $data Variable that want to be hashed.
   * @return string $result Result of the hashed value.
   */
  public static function make($data)
  {
    return password_hash($data, PASSWORD_DEFAULT);
  }
}