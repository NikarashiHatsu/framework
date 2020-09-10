<?php

namespace Shiroyuki\Database;

use Mysqli;
use Shiroyuki\Database\QueryBuilder;

abstract class Connection {
  use QueryBuilder;

  /**
   * The engine used. Currently, supported type is Mysql.
   * 
   * @var string
   */
  protected $engine = 'mysql';

  /**
   * The host used.
   * 
   * @var string
   */
  protected $db_host;

  /**
   * The username used in the host.
   * 
   * @var string
   */
  protected $db_user;

  /**
   * The password used in the host.
   * 
   * @var string
   */
  protected $db_pass;

  /**
   * The database used.
   * 
   * @var string
   */
  protected $db_name;

  /**
   * The port used.
   * 
   * @var int
   */
  protected $db_port;

  /**
   * The connection object.
   * 
   * @var object
   */
  protected $connection;

  /**
   * Load the .env configuration
   */
  public function __construct()
  {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    
    $db_host = $_ENV['DB_HOST'];
    $db_user = $_ENV['DB_USER'];
    $db_pass = $_ENV['DB_PASS'];
    $db_name = $_ENV['DB_NAME'];
    $db_port = $_ENV['DB_PORT'];
    
    $this->db_host = $db_host;
    $this->db_user = $db_user;
    $this->db_pass = $db_pass;
    $this->db_name = $db_name;
    $this->db_port = $db_port;

    $this->setConnection();

    return $this;
  }

  /**
   * Set the connection for models.
   * 
   * @return Mysqli $database
   */
  public function setConnection()
  {
    $db = new Mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->db_port);
    
    return $this->connection = $db;
  }
}