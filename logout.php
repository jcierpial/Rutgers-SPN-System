<?php
/*
	This page is responsible for unsetting the username and authentication for the user when they try to log out. Thr session being used is destroyed for safety reasons.
*/
session_start();
if(isset($_SESSION['netID']))
    unset($_SESSION['netID']); 
if(isset($_SESSION['password']))
    unset($_SESSION['password']); 
session_destroy(); 
// Requires absolute URL? header( 'Refresh: 5; Location: /index.php' );
?>
<html>
<body>
<center>You have been successfully logged out.<br />Please <a href = "/index.php">click here</a> to be redirected to the login page.<br /></center>
</body>
</html>