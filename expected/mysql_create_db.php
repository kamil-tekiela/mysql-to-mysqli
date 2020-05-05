<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = new \mysqli('localhost', 'mysql_user', 'mysql_password');

$link->query('CREATE DATABASE my_db');
