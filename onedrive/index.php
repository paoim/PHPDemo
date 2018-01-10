<?php

// Error Reporting
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 'on');

defined('APP_PATH') || define('APP_PATH', realpath(dirname(__FILE__)));

require_once 'app/ApiController.php';
//set_time_limit(300);
//ini_set('memory_limit', '256M');

// Create application and run
ApiController::instance()->run();
