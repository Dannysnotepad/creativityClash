<?php
session_start();

$routes = [
  '/' => 'index.php',
  '/signup' => 'signup.php',
  '/login' => 'login.php',
  '/submit' => 'submit.php',
  '/submitted-projects' => 'submitted-projects.html',
  '/adminlogin' => 'adminlogin.php',
  '/admin' => 'admin.php',
  '/404' => '404.php'
  //'/logout' => '/logout.php'
  ];
  $uri = $_SERVER['REQUEST_URI'];
  if(array_key_exists($uri, $routes)){
     include $routes[$uri];
  }else{
    //header('HTTP/1.0 404 not found');
    include $routes['/404'];
  }
