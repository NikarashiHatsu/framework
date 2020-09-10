<?php

namespace Shiroyuki;

use Shiroyuki\App\Database as ShiroyukiDatabase;
use Shiroyuki\App\Model as ShiroyukiModel;

class Shiroyuki {
  /**
   * Database instance
   */
  private $database;

  /**
   * Model instance
   */
  private $model;
  
  /**
   * Constructor
   */
  public function __construct()
  {
    $this->database = new ShiroyukiDatabase;
    $this->model = new ShiroyukiModel;
  }
}