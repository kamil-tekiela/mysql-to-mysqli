<?php
$link = mysql_connect('localhost', 'mysql_user', 'mysql_password');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
if (!mysql_select_db('database_name')) {
    die('Could not select database: ' . mysql_error());
}

$id = 1;
$name = 'Dharman';
$result = mysql_query("SELECT name FROM employees WHERE id=$id AND name='".mysql_real_escape_string($name)."'") 
	or die('Could not query:' . mysql_error());