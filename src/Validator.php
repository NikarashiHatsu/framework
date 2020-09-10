<?php

namespace Shiroyuki;

use Shiroyuki\Web\Request;
use Shiroyuki\Validator\Rules;
use Shiroyuki\Validator\ErrorMessages;
use Shiroyuki\View\Redirection;

class Validator {
  /**
   * Validate the requests.
   * 
   * @param array $requested_data.
   */
  public static function validate($requested_data) {
    $invalid_datas = [];

    foreach($requested_data as $key => $item) {
      $request = new Request;
      $value = $request->$key;

      foreach($item as $rule) {
        $rule_error_message = $rule . '_error_message';
        $validated = false;

        preg_match("/max\:/", $rule, $max);
        if(count($max) > 0) {
          $max = explode(':', $rule);
          $validated = !$validated;
          !Rules::max($value, $max[1]) ? array_push($invalid_datas, [$key => ErrorMessages::max_error_message($key, $max[1])]) : '';
        }

        preg_match("/min\:/", $rule, $min);
        if(count($min) > 0) {
          $min = explode(':', $rule);
          $validated = !$validated;
          !Rules::min($value, $min[1]) ? array_push($invalid_datas, [$key => ErrorMessages::min_error_message($key, $max[1])]) : '';
        }

        preg_match("/in\:[a-z]\w+\,/", $rule, $in);
        if(count($in) > 0) {
          $in = explode(':', $rule);
          $validated = !$validated;
          !Rules::in($value, $in[1]) ? array_push($invalid_datas, [$key => ErrorMessages::in_error_message($key, $in[1])]) : '';
        }

        if($rule == "confirmed") {
          $confirmed_field = "confirm_" . $key;
          $confirmed_value = $request->$confirmed_field;
          $validated = !$validated;
          !Rules::confirmed($value, $confirmed_value) ? array_push($invalid_datas, [$key => ErrorMessages::confirmed_error_message($key)]) : '';
        }

        if(!$validated) {
          !Rules::$rule($value) ? array_push($invalid_datas, [$key => ErrorMessages::$rule_error_message($key)]) : '';
        }
      }
    }

    if(count($invalid_datas) > 0) {
      $redirect = new Redirection;
      return $redirect->back()->with('error', $invalid_datas);
    }
  }
}