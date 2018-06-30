<?php
session_start();
require_once('config.php');
require_once('functions.php');
  spl_autoload_register(function ($class){
    $class = strtolower($class);
    $class = str_replace('\\', '/', $class); 
    $path  = $class . '.php';

    if (file_exists($path)) {
      require_once $path;
    } 
  });

$router = new Helpers\Router($_GET,$_POST);
$router->start();














?>