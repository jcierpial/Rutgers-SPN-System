<strong><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login php</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
</head>
</strong>
<body>

<?php
session_start();
include 'connect.php';
$netID = $_POST['netID'];
$password = $_POST['password'];
$login = "index.php";
$sql = mysql_query("SELECT * FROM users WHERE netid = '". $netID ."' AND password = '". $password ."'", $link);
$sqlarray = mysql_fetch_assoc($sql);
if( mysql_num_rows($sql) != 0 ) 
{ 
	if($sqlarray["auth"] == 0)
	{
		//Is in database
		$_SESSION['auth']=0;	
		$_SESSION['netID']=$netID;
		$_SESSION['password']=$password;
		
		header ( 'Location: admin.php');
	}
	else if($sqlarray["auth"] == 1)
	{
		//Is in database	
		$_SESSION['auth']=1;
		$_SESSION['netID']=$netID;
		$_SESSION['password']=$password;
		$_SESSION['ruid'] = $sqlarray['ruid'];
		header ( 'Location: studentwelcome.php');
	}	
	else if($sqlarray["auth"] == 2)
	{
		//Is in database	
		$_SESSION['auth']=2;
		$_SESSION['netID']=$netID;
		$_SESSION['password']=$password;
		header ( 'Location: test.php?netid=' . $netID . '&mode=0');
	}
}
else 
{ 
	echo "<CENTER> An error occured while trying to log you in. <BR> Go to the login page and try again.<BR><A HREF=$login>Click here</A> to try logging in again.";
}
?>
</body>
</html>
