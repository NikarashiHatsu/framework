<?php

namespace Shiroyuki\Database;

trait QueryBuilder {
  /**
   * The final query that has been built.
   * 
   * @var string
   */
  protected $query;

  /**
   * The select columns.
   * 
   * @var string
   */
  protected $selectColumns = "*";

  /**
   * The where columns.
   * 
   * @var string
   */
  protected $whereColumns = "";

  /**
   * The INSERT INTO columns.
   * 
   * @var string
   */
  protected $insertIntoColumns = "";

  /**
   * The INSERT INTO's VALUE.
   * 
   * @var string 
   */
  protected $insertIntoValues = "";

  /**
   * Build the select query.
   * 
   * @return bool|string $result
   */
  public function buildSelect($columns = ['*'])
  {
    if(!is_array($columns)) {
      return false;
    }

    $result = "";

    for($i = 0; $i < count($columns); $i++) {
      $result .= $columns[$i];

      if($i != count($columns) - 1) {
        $result .= ", ";
      }
    }

    return $this->selectColumns = $result;
  }

  /**
   * Build an INSERT INTO query
   * 
   * @param array $columns
   * @return array
   */
  public function buildInsert($columns = [])
  {
    $query = "";
    
    for($i = 0; $i < count($columns); $i++) {
      $query .= "`" . $columns[$i] . "`";
      
      if($i != count($columns) - 1) {
        $query .= ", ";
      }
    }

    return $this->insertIntoColumns = "(" . $query . ")";
  }

  /**
   * Build the VALUES for INSERT INTO query
   * 
   * @param array $values
   * @return array
   */
  public function buildInsertValues($values = [])
  {
    $query = "";

    for($i = 0; $i < count($values); $i++) {
      $query .= "'" . $values[$i] . "'";
      
      if($i != count($values) - 1) {
        $query .= ", ";
      }
    }

    return $this->insertIntoValues = "(" . $query . ")";
  }

  /**
   * Build the single where statement.
   * 
   * @return string
   */
  public function buildWhere($columns)
  {
    if(count($columns) == 3) {
      return $this->whereColumns = $columns[0] . " " . $columns[1] . " '" . $columns[2] . "'";
    } else {
      return $this->whereColumns = $columns[0] . " = '" . $columns[1] . "'";
    }
  }

  /**
   * Build the multiple where statement.
   * 
   * @return string
   */
  public function buildMultipleWhere($columns)
  {
    $result = "";

    for($i = 0; $i < count($columns); $i++) {
      if(count($columns[$i]) == 3) {
        $result .= $columns[$i][0] . " " . $columns[$i][1] . " '" . $columns[$i][2] . "'";    
      } else {
        $result .= $columns[$i][0] . " ='" . $columns[$i][1] . "'";
      }

      if($i != count($columns) - 1) {
        $result .= " AND ";
      }
    }
    
    $this->whereColumns = $result;
  }

  /**
   * Build the query.
   * 
   * @return string $result
   */
  public function buildQuery()
  {
    if($this->insertIntoColumns == "" && $this->insertIntoValues == "") {
      // Build SELECT
      $result = "SELECT " . $this->selectColumns . " FROM " . $this->table;
    } else {
      // Build WHERE
      $result = "INSERT INTO `" . $this->table . "`" . $this->insertIntoColumns . " VALUES" . $this->insertIntoValues;      
    }

    // WHERE statement
    if($this->whereColumns != "") {
      $result .= " WHERE " . $this->whereColumns;
    }

    return $this->query = $result;
  }

  /**
   * Run the query
   * 
   * @return array|object $result
   */
  public function runQuery()
  { 
    $this->buildQuery();
    
    $db = $this->connection;
    $stmt = $db->prepare($this->query);
    $stmt->execute();

    if($this->insertIntoColumns == "" && $this->insertIntoValues == "") {
      // SELECT
      $result = $stmt->get_result();
      $stmt->close();
  
      $final = [];
  
      while($row = $result->fetch_assoc()) {
        array_push($final, (object) $row);
      }
  
      return $this->result = $final;
    } else {
      // INSERT INTO
      return $stmt;
    }
  }
}