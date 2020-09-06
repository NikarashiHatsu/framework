<?php

namespace Shiroyuki\Routes;

trait RouteList {
  /**
   * Defined HTTP Routes
   * 
   * @var array
   */
  public $httpRoutes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => [],
  ];

  /**
   * Defined API Routes
   * 
   * @var array
   */
  protected $apiRoutes = [];
}