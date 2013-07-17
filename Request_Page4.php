<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Request SP Final</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<?php
	
				
	include 'connect.php';
	session_start();
	$dept = $_SESSION['deptdropdown'];
	$course = $_SESSION['coursedropdown'];
	$ruid = $_SESSION['ruid'];
	$section = $_SESSION['sectiondropdown'];
	$gradyear = $_POST[gradyear];
	$_SESSION['gradyear'] = $gradyear;
	$netid = $_SESSION['netID'];
	
	if($_POST[mandatory] == "notrequired")
		$is_required = 0;
	else
		$is_required = 1;
	if($_POST[onemoretime] == "notretaking")
		$is_retaking = 0;
	else
		$is_retaking = 1;
	$explanation = mysql_real_escape_string($_POST[studcomments]);
	$gpa = $_POST[gpa];
	$_SESSION['gpa'] = $gpa;
	$major = $_POST[major];
	$_SESSION['major'] = $_POST[major];
	//date_default_timezone_set('America/New_York');
	$date = date('Y-m-d H:i:s');
	$query = "SELECT DISTINCT course_number FROM courses WHERE course_title = '$course' AND dept = '$dept'";
	$result = mysql_query($query);
	$prereqs = $_SESSION['prereq_grades'];
	$queryforname = "SELECT * FROM users WHERE netid = '$netid'";
	$tryit = mysql_query($queryforname);
	while($firstrow = mysql_fetch_array($tryit)){
		$name = $firstrow['first_name'] . " " . $firstrow['last_name'];
	}
	//echo "NAME IS: " . $name;
	while($row = mysql_fetch_array($result))
		{	
			$course_number = $row['course_number'];
		}
	$query2 = "SELECT * FROM users WHERE netid = '$netid'";
	$result2 = mysql_query($query2);
	while($row2 = mysql_fetch_array($result2))
		{
			$email = $row2['email'];
			//$name = $row2['name'];
		}
	$sql="INSERT INTO course_requests (name, ruid, netid, email, dept, course_number, section_number, course_title, gpa, grad_year, is_retaking, major, is_required, prereqs, explanation, submission_time ) VALUES('$name', '$ruid', '$netid', '$email', '$dept', '$course_number', '$section', '$course', '$gpa', '$gradyear', '$is_retaking', '$major', '$is_required', '$prereqs', '$explanation', '$date')";
	echo " <div id='header'>
            <div id='logo'>
                <img src='rutgers_logo.jpg' width='400' height='150' />
            </div>
           <div id='menu'>
			<ul>
				<li><a href='studentwelcome.php' accesskey='0'>Student Welcome Page</a> </li>
				<li><a href='View_Requests.php' accesskey='1'>View/Delete SPN Statuses</a></li>
				<li><a href='Request_Page1.php' accesskey='2'>Request Special Permission Numbers</a></li>
				<li><a href='logout.php' accesskey='4'>Log Out</a></li>
			</ul>
		</div>
    </div>";
	if (!mysql_query($sql))
		{ 
		echo $sql;
		echo "<br><CENTER> An error occured while trying to make this course request. Click the Student Welcome link above to return and try again.";
	}
	else{
		echo "<br><CENTER> The course submission was successful! Click one of the links above to continue or return to the Student Welcome page.";
	}
 ?>
</body>
</html>
