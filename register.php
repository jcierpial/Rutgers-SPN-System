<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration Confirmation</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<?php
include "connect.php";
$register = "registration.html";
/*This page is responsible for creating a new entry in the "user" table using the post values submitted by the user. 
  Connecting to database and checking if the current username was already chosen.
  If it was, user is prompted to restart the registration process and try with different username.
*/

session_start();
//Resetting the username and authentication entry in the session for safety reasons.

if(isset($_SESSION['netID']))
    unset($_SESSION['netID']); 

if(isset($_SESSION['auth']))
    unset($_SESSION['auth']); 

$netID = $_POST['netID'];
$ruid = $_POST['ruid'];
$auth = $_POST['auth'];
if($auth == 1){
	$duplicate = "SELECT * FROM users WHERE netid='$netID' OR ruid='$ruid' AND auth=1;";
}
else{
	$duplicate = "SELECT * FROM users WHERE netid='$netID' AND ruid='$ruid'";
}
$result = mysql_query($duplicate);
if(mysql_num_rows($result)!=0)
{
	echo "<CENTER>An error occurred, you are already registered. <BR> Go to the login page and try again.<BR>
	<A HREF=$register>Click here</A> to try registering again.";
}
else 
{
	//It is ascertained that the netID is not already used, so using the form entries to create a new entry in the user table.
	if(!is_numeric($ruid))
	{
		echo"<CENTER>An error occurred, your RUID can only be comprised of digits.<br>Go to the registration page and try again.<BR><A HREF=$register>Click here</A> to try registering again.";
	}
	else
	{
		$sql="INSERT INTO users (netid, password, first_name, last_name, ruid, email, auth)VALUES('";
		$sql = $sql . $_POST[netID] . "','" . $_POST[password] . "',";
		$sql = $sql . "'" . $_POST[firstname] . "','" . $_POST[lastname] . "','" . $_POST[ruid] . "',";
		$sql = $sql . "'" . $_POST[email] . "'," . $_POST[auth] . ");";

		if (!mysql_query($sql))
		{
			echo "<center>";
			echo "<p>Sorry, the registration was not successful. </p>";
			echo "<p>Please make sure that you supplied valid information in the registration form.</p>";
			echo "<p>Click <A HREF=$register>here</A> to restart the registration process.</p>";
			echo "</center>";
			
		}
		else
		{
			$_SESSION[netID] = $_POST[netID];
			$_SESSION[auth] = $_POST[auth];
			$_SESSION['ruid'] = $_POST[ruid];
			echo "<center>";
			echo "<p>The registration was successful!</p>";
			echo "<p>Click <A HREF=\"/index.php\"> here</A> to continue and login!</p>";
	  }
	}
}
?>
</body>
</html>
