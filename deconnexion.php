<?php
require_once('includes/php_header.php');
unset($_SESSION['user']);
header('Location: index.php');
