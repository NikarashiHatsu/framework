<?php

namespace Shiroyuki\Validator;

class Rules {
  /**
   * Check if the key is string or not.
   */
  public function string($value)
  {
    return (is_string($value)) ? true : false;
  }

  /**
   * Validate the desired minimun length of a string.
   * 
   * @return bool
   */
  public static function min($value, $min)
  {
    return strlen($value) >= $min;
  }

  /**
   * Validate the desired maximum length of a string.
   * 
   * @return bool
   */
  public static function max($value, $max)
  {
    return strlen($value) <= $max;
  }

  /**
   * Validate if the string is empty or not.
   * 
   * @param bool|string $value
   * @return bool
   */
  public static function required($value)
  {
    return !(is_null($value) || $value == "") ? true : false;
  }

  /**
   * Validate if the string is an email.
   * 
   * @param string $value
   * @return bool
   */
  public static function email($value)
  {
    return (filter_var($value, FILTER_VALIDATE_EMAIL));
  }

  /**
   * Validate the confirmed key.
   * 
   * @param string $value
   * @param string $confirmed_value
   * @return bool
   */
  public static function confirmed($value, $confirmed_value)
  {
    return $value === $confirmed_value;
  }

  /**
   * Validate the enum typed value.
   * 
   * @param string $value
   * @param string $enums
   * @return bool
   */
  public static function in($value, $enums)
  {
    $valid = false;

    foreach(explode(',', $enums) as $item) {
      if($value === $item) {
        $valid = true;
      }
    }

    return $valid;
  }
}