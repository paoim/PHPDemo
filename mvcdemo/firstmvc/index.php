<?php

require_once 'helpers/Application.php';

/**
 * Structure:
 * Example: index/run/123
 * 1. index is controller
 * 2. run is method of index controller
 * 3. 123 is parameter in run method of index controller
 */
$App = Application::instance();
$App->run();
