<?php

namespace Shiroyuki\Database;

use Shiroyuki\Database\Connection;

abstract class Model extends Connection {
  /**
   * The table used.
   * 
   * @var string
   */
  protected $table = '';

  /**
   * The primary key used.
   * 
   * @var string
   */
  protected $primaryKey = 'id';

  /**
   * The type of the primary key
   * 
   * @var string
   */
  protected $keyType = 'int';

  /**
   * Indicates if the IDs are auto-incrementing.
   * 
   * @var bool
   */
  protected $incrementing = true;

  /**
   * Check if the model can used "all" function or not.
   * 
   * @var bool
   */
  protected $canUseAll = true;  
  
  /**
   * The result of the query that has been executed.
   * 
   * @var object
   */
  protected $result;

  /**
   * Get all the columns.
   * 
   * @param array $columns
   * @return void
   */
  public function all($columns = ['*'])
  {
    if($this->canUseAll) {
      $this->buildSelect($columns);
      $this->runQuery();

      return $this->result;
    }
  }

  /**
   * Build the where statement.
   * 
   * @return bool|object
   */
  public function where($columns = [])
  {
    if(!is_array($columns)) {
      return false;
    }

    // Check if it's multidimensional array or not
    if(is_array($columns[0])) {
      $this->buildMultipleWhere($columns);
    } else {
      $this->buildWhere($columns);
    }

    return $this;
  }

  /**
   * Get all the columns with filtered conditions.
   * 
   * @return void
   */
  public function get()
  {
    $this->canUseAll = false;

    $this->runQuery();

    return $this->result;
  }

  /**
   * Get the first object.
   * 
   * @return bool
   */
  public function first()
  {
    $result = $this->runQuery();
    
    $this->result = $result[0];

    return $this->result;
  }

  /**
   * Paginate the result.
   * 
   * @return object $result
   */
  public function paginate($rows)
  {
    $this->runQuery();

    return $this->result;
  }

  /**
   * Save the data to the database.
   * 
   * @return bool
   */
  public function save()
  {
    $json_data = json_encode($this);
    $columns = [];
    $values = [];

    foreach(json_decode($json_data) as $key => $value) {
      array_push($columns, $key);
      array_push($values, $value);
    }

    $this->buildInsert($columns);
    $this->buildInsertValues($values);
    $this->buildQuery();

    $errno = $this->runQuery()->errno;

    return !$errno;
  }
}