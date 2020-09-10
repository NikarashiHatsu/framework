<?php

namespace Shiroyuki\Database;

use Shiroyuki\Database\Database;

class SelectOperation extends Database {
  /**
   * Select one column
   */
  public function select_column($columns)
  {
    // If the columns is more than one
    if(is_array($columns)) {
      return $columns;
    }

    // If the columns is single
    return $columns;
  }
}