<?php

namespace Shiroyuki\Server;

trait Variables {
  /**
   * The "route" taken from $_SERVER[REQUEST_URI].
   * 
   * @var string
   */
  protected $requestUri;

  /**
   * The "request method" taken from $_SERVER[REQUEST_METHOD].
   * 
   * @var string
   */
  protected $requestMethod;

  /**
   * The "server name" taken from $_SERVER[SERVER_NAME].
   * 
   * @var string
   */
  public $serverName;

  /**
   * The "server directory" just in case this application is deployed on a
   * sub-folder of an application.
   */
  protected $serverDirectory = "";

  /**
   * Set all the variables
   * 
   * @return void
   */
  public function setVariables()
  {
    $this->setSelf();
    $this->setRequestMethod();
    $this->setServerName();
  }

  /**
   * Set the self using value from $_SERVER[REQUEST_URI].
   * 
   * @return void
   */
  protected function setSelf()
  {
    if($this->serverDirectory != "") {
      $this->requestUri = str_replace($this->serverDirectory, '', $_SERVER['REQUEST_URI']);
    } else {
      $this->requestUri = $_SERVER['REQUEST_URI'];
    }
  }

  /**
   * Set the request method using value from $_SERVER[REQUEST_METHOD].
   * 
   * @return void
   */
  protected function setRequestMethod()
  {
    $this->requestMethod = $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Set the server name using value from $_SERVER[SERVER_NAME].
   * 
   * @return void
   */
  protected function setServerName()
  {
    $this->serverName = $_SERVER['SERVER_NAME'];
    
    return $this;
  }

  /**
   * Return base url of the application.
   * 
   * @return string
   */
  public function baseUrl()
  {
    $request_scheme = $_SERVER['REQUEST_SCHEME'];
    $server = $_SERVER['SERVER_NAME'];
    $url = $request_scheme . '://' . $server;

    return $url;
  }
}