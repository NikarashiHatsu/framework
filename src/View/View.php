<?php

namespace Shiroyuki\View;

class View {
  /**
   * Return the expected view.
   * 
   * @param array $page
   * @return void
   */
  public function view($page)
  {
    $directory = explode('.', $page);
    $fixed_page = "";

    if(is_array($directory)) {
      for($i = 0; $i < count($directory); $i++) {
        $fixed_page .= $directory[$i];

        ($i != count($directory) - 1) ? $fixed_page .= "/" : "";
      }
    } else {
      $fixed_page = $page;
    }
    
    require_once __DIR__ . '/../../app/View/' . $fixed_page . '.php';
  }
}