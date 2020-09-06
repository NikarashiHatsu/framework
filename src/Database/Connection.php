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
  protected $host = '127.0.0.1';

  /**
   * The username used in the host.
   * 
   * @var string
   */
  protected $user = 'root';

  /**
   * The password used in the host.
   * 
   * @var string
   */
  protected $password = 'root';

  /**
   * The database used.
   * 
   * @var string
   */
  protected $database = 'test';

  /**
   * The port used.
   * 
   * @var int
   */
  protected $port = 3306;

  /**
   * The connection object.
   * 
   * @var object
   */
  protected $connection;

  /**
   * Set the connection for models.
   * 
   * @return Mysqli $database
   */
  public function setConnection()
  {
    $db = new Mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
    
    return $this->connection = $db;
  }
}