<?php

namespace Shiroyuki\Controller;

use Shiroyuki\View\View;
use Shiroyuki\View\Redirection;

trait Controller {
  /**
   * Use all the traits
   */
  use Redirection;
  
  /**
   * A function to show the index of a module.
   * 
   * @return void
   */
  public function index() {
    //
  }

  /**
   * A function to show the form of a module.
   * 
   * @return void
   */
  public function create() {
    //
  }

  /**
   * A function to store the data from the create() function to the database.
   * 
   * @return void
   */
  public function store() {
    //
  }

  /**
   * Show the detail of a data.
   * 
   * @return void
   */
  public function show() {
    //
  }

  /**
   * Show an editting form for the specific data requested.
   * 
   * @return void
   */
  public function edit() {
    //
  }

  /**
   * Update the requested data from the database.
   * 
   * @return void
   */
  public function update() {
    //
  }

  /**
   * Delete the data form the database.
   * 
   * @return void
   */
  public function delete() {
    //
  }

  /**
   * Return the view.
   * 
   * @param string $page
   * @return void
   */
  public function view($page, $session = [])
  {
    if(count($session) > 0) {
      $this->session()->set($session);
    }

    $view = new View;
    $view->view($page);
  }
}