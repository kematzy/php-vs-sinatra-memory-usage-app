<?php

# set the APP_ROOT first of all
define('APP_ROOT', dirname(dirname(__FILE__)) );

# Load Limonade framework
require_once APP_ROOT . '/lib/limonade.php';

## ADD EXTRA FEATURES HERE


## CONFIGURATIONS::
function configure()
{ 
  option('views_dir', APP_ROOT . '/views');
  option('lib_dir', APP_ROOT . '/lib');
  option('base_uri', '/');
  option('debug', false);
}


## CALLBACKS::
# This code will be executed before each route action below:
function before()
{ 
  layout('layout.html.php');
}

# This code will be executed after each route action below:
function after($output) 
{ 
  $output .= "<p style=\"text-align: center; color: grey;\"> memory usage " . size_to_str(memory_get_peak_usage(true)) ." at peak </p>";
  return $output;
}



## ROUTES 
dispatch('/', 'home');
function home() {
  return html('index.html.php');
}


## ERROR 404
function not_found($errno, $errstr, $errfile=null, $errline=null) {
  return html("error/404.html.php",'');
}

## ERROR 500
function server_error($errno, $errstr, $errfile=null, $errline=null) {
  $args = compact('errno', 'errstr', 'errfile', 'errline');
  return html("error/500.html.php", '', $args);
}


## RUN THE APP
run();


?>