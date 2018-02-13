<link rel="stylesheet" type="text/css" href="backgr.css">
<?php
require 'core.inc.php';
require 'connect.php';

if(loggedin()){
	header('Location: dateselect.php');
} else {
	include('loginform.inc.php');
}

?>