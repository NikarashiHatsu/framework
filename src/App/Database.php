<?php

namespace Shiroyuki\App;

use Mysqli;

class Database {
  /**
   * Database's host
   */
  private $db_host;

  /**
   * Database's port
   */
  private $db_port;

  /**
   * Database's username
   */
  private $db_user;

  /**
   * Database's password
   */
  private $db_pass;

  /**
   * Database's name
   */
  private $db_name;

  /**
   * Complete database reference
   */
  public $instance;

  /**
   * Constructor function using Mysqli
   * 
   * @param Mysqli $mysqli
   */
  public function __construct()
  {
    $this->db_host = $_ENV['DB_HOST'];
    $this->db_port = $_ENV['DB_PORT'];
    $this->db_user = $_ENV['DB_USER'];
    $this->db_pass = $_ENV['DB_PASS'];
    $this->db_name = $_ENV['DB_NAME'];
    
    $mysqli = new Mysqli(
      $this->db_host,
      $this->db_user,
      $this->db_pass,
      $this->db_name,
      $this->db_port
    );

    return $this->instance = $mysqli;
  }
}