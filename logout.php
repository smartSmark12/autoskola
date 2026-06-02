<?php
require_once __DIR__ . "/framework/auth.php";
Auth::logout();
header('Location: login.php');
exit;
