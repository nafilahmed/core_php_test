<?php
session_start();
ini_set('display_errors', 1);

require_once 'app/backend/auth/config.php';
require_once 'app/backend/core/Helpers.php';

spl_autoload_register("autoload");

require_once 'app/backend/auth/user.php';
require_once 'app/backend/auth/timezone.php';
require_once './sync-namaz-time.php';
