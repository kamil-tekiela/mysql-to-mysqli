<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = new \mysqli('localhost', 'mysql_user', 'mysql_password', 'database_name');

$result = $link->query('SELECT name FROM work.employee');
$result->data_seek(2);
echo $result->fetch_row()[0]; // outputs third employee's name

$link->close();
