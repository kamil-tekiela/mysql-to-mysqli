<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = new \mysqli('localhost', 'mysql_user', 'mysql_password');
$charset = $link->character_set_name();
