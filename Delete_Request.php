<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delete Request</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>

<?php
	session_start();
	include 'connect.php';
	$sql = mysql_query($_SESSION['request_to_delete']);
	if(!$sql){
		echo "<CENTER> An error occured while trying to delete the course request. <BR>";
	}
	header( 'Location: View_Requests.php');
 ?>
	
</body>
</html>