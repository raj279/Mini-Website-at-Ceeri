<?php
define('mysql_host', 'localhost');
define('mysql_user', 'root');
define('mysql_pass', '');
define('mysql_db', 'users');

$con = mysqli_connect(mysql_host,mysql_user,mysql_pass,mysql_db);

if(!$con){
	die("connection failed: ". mysqli_connect_error());
}

?>