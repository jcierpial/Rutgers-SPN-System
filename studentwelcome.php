<?php
SESSION_start();
if ($_SESSION['auth']!=1 || !isset($_SESSION['auth'])) 
{
  header('HTTP/1.1 403 Forbidden');
  exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Welcome Page</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
	<div id="header">
		<div id="logo">
			<img src="rutgers_logo.jpg" width="400" height="150" alt="" />
		</div>
		<div id="menu">
			<ul>
            	<!--<li><a href="update_requests.php"> Test this out </a></li> -->
				<li><a href="View_Requests.php" accesskey="1" title="">View/Delete SPN Statuses</a></li>
				<li><a href="Request_Page1.php" accesskey="2" title="">Request Special Permission Numbers</a></li>
				<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
			</ul>
		</div>
	</div>
	<div id="page">
	  <div id="content">
            <?php
session_start();
include 'connect.php';
echo '<h2> Welcome '. $_SESSION['netID'] . '!</h2>';
?>
			<p>Welcome to the course selection page! Click on any of the links above to continue!</p>
</div>
</div>
</body>
</html>