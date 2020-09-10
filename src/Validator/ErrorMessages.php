<?php

namespace Shiroyuki\Validator;

class ErrorMessages {
  /**
   * Show string error message.
   * 
   * @param string $field
   * @return string
   */
  public static function string_error_message($field)
  {
    return "Field {$field} must be a string.";
  }

  /**
   * Show the min() error message.
   * 
   * @param string $field
   * @param int $min_length
   * @return string
   */
  public static function min_error_message($field, $min_length)
  {
    return "Minimum length of {$field} is {$min_length} characters.";
  }

  /**
   * Show the max() error message.
   * 
   * @param string $field
   * @param int $max_length
   * @return string
   */
  public static function max_error_message($field, $max_length)
  {
    return "Maximum length of {$field} is {$max_length} characters.";
  }

  /**
   * Show the required() error message.
   * 
   * @param string $field
   * @return string
   */
  public static function required_error_message($field)
  {
    return "Field {$field} must not empty.";
  }
  
  /**
   * Show the email() error message.
   * 
   * @param string $field
   * @return string
   */
  public static function email_error_message($field)
  {
    return "Field {$field} must be a valid email address.";
  }

  /**
   * Show the confirmed() error message.
   * 
   * @param string $key
   * @return string
   */
  public static function confirmed_error_message($key)
  {
    return "Field {$key} doesn't match the confirmation value.";
  }
  
  /**
   * Show the in() error mesasge.
   * 
   * @param string $key
   * @param string $enums
   * @return string
   */
  public static function in_error_message($key, $enums)
  {
    $in = "";

    foreach(explode(',', $enums) as $key => $item) {
      $in .= $item;
      
      if(($key + 1) < count(explode(',', $enums)) - 1) {
        $in .= " ,";
      }
    }

    return "Field {$key} should be filled with {$in}.";
  }
}