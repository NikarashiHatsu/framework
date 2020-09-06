<?php
  ini_set('display_errors', 1);

  session_start();

  require __DIR__ . '/vendor/autoload.php';
  require __DIR__ . '/app/Bootstrap/app.php';
  // $user = new App\Model\User;
  // $user->all();
  // $user->all(['id', 'username', 'email']);
  // $user->where([['username', '=', 'shiroyuki'], ['email', '=', 'shiroyuki@domain.id']]);
  // $user->where(['username', 'shiroyuki'])->get();
  // $user->first();
  // print_r($user->result);

  // header("Content-Type: application/json");
  // echo json_encode($_SERVER);
  // echo $route->self;
  // print_r($route->httpRoutes);
?>