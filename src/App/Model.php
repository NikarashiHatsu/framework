<?php

namespace Shiroyuki\App;

use Shiroyuki\App\Database as ShiroyukiDatabase;

class Model extends ShiroyukiDatabase {
  /**
   * Model's table
   */
  public $table = '';

  /**
   * Model's database
   */
  private $db;

  /**
   * Constructor function
   */
  public function __construct()
  {
    $db = new ShiroyukiDatabase;
    $instance = $db->instance;

    return $this->db = $instance;
  }
  
  /**
   * Retrieve all columns
   */
  public function all()
  {
    $query = "SELECT * FROM `$this->table`";
    $data = $this->instance->query($query);
    echo $data;

    // return $data->fetch_assoc();
  }
}