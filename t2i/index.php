<?php
ob_start();

//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();

include_once 'app/includes.php';

require_once 'app/init.php';
$app = new App;