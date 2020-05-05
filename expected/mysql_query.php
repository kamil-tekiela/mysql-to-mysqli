<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = new \mysqli('localhost', 'mysql_user', 'mysql_password', 'database_name');

$id = 1;
$name = 'Dharman';
$stmt = $link->prepare('SELECT name FROM employees WHERE id=? AND name=?');
$stmt->bind_param('is', $id, $name);
$stmt->execute();
$result = $stmt->get_result();
