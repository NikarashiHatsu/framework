<?php

use \Shiroyuki\Server;

/**
 * Helper function.
 * 
 * @param string $file_directory Asset's file directory target.
 * @return string $file_url File url.
 */
function asset($file_directory = "") {
  $server = new Server;
  $url = $server->baseUrl();

  return $url . '/public/' . trim($file_directory, '/');
}

/**
 * Url function.
 * 
 * @param string $destination
 * @return string $url
 */
function url($destination = "") {
  $server = new Server;
  $url = $server->baseUrl();

  return $url . '/' . trim($destination, '/');
}

/**
 * Make the breadcrumb.
 * 
 * @return string $html
 */
function breadcrumb() {
  $uri = explode('/', trim(Server::getUri(), '/'));
  $html = "";
  
  for($i = 0; $i < count($uri); $i++) {
    $url = url($uri[$i]);
    $html .= "<a href='" . $url . "'>" . ucwords(str_replace('_', ' ', $uri[$i])) . "</a>";
    
    if($i != count($uri) - 1) {
      $html .= "<span class='mx-1'>/</span>";
    }
  }

  return "<div>" . $html . "</div>";
}

/**
 * Get the CSRF token and store it to the _token input.
 * 
 * @return string $html A hidden input with the key value.
 */
function csrf()
{
  $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
  $dotenv->load();

  $key = $_ENV['KEY'];
  $html = "<input type='hidden' value='" . $key . "' />";

  return $html;
}