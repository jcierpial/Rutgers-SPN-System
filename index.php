<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login!</title>

<SCRIPT LANGUAGE="JavaScript">
	function validate(){
		if(document.form1.netID.value == "" || document.form1.password.value == ""){
			alert("Please make sure to supply a valid netID and password");
			return false;
		}else{
			if(document.form1.netID.value.length > 15 || document.form1.password.value.length > 15){
				alert("Please make sure that your netID and password are less than 16 charecters long");
				document.form1.netID.value = ""; document.form1.password.value = "";
				return false;
			}else{
				return true;
			}
		}
	}
</SCRIPT>
</head>
<body> 
<?php
session_start();
include 'connect.php';
	if(isset($_SESSION['netID'])){
		if($_SESSION['auth']==0){
			header( 'Location: admin.php');
		}
		if($_SESSION['auth']==1){
			header( 'Location: studentwelcome.php');
		}
		if($_SESSION['auth'] == 2){
			header( 'Location: test.php?mode=0&netid=' . $_SESSION['netID']);
		}
	}
?>
<table width="100%" border="0" cellspacing="5" align="right">
  <tr>
    <td width="37%" align="right">
    
	</td>
    <td width="40%">

	<form name="form1" method="post" action="login.php" onsubmit="return validate()">
	<fieldset>
	<legend>Sign up for Classes!</legend>
	<p><label>NetID</label> <input type="text" name="netID" id="netID" /></p>
    <p><label>Password:   </label> <input type="password" name="password" id="password" /><br /></p>
    <p class="submit"><input type="submit" name = "login" value="Sign in" /></p>
    </fieldset>
    </form>
      <table width="100%" border="0" cellspacing="5">
	    <tr>
		<td colspan="3" style="text-align:center; font-family:Georgia, 'Times New Roman', Times, serif">
			<p>Log in to use with your netID or <A HREF="registration.html">sign up</A> if you haven't already set up your account.</p>
      </table>
        </form>
    </td>
    <td>
   </td>
  </tr>
</table>

<p>&nbsp;</p>
</body>
</html>
