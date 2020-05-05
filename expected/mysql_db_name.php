<?php
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = new \mysqli('dbhost', 'username', 'password');
$db_list = $link->query('SHOW DATABASES');

foreach ($db_list as $db_list_row) {
    echo $db_list_row['Database'] . "\n";
}
