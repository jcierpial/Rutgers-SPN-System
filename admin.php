<?php
SESSION_start();
if ($_SESSION['auth']!=0 || !isset($_SESSION['auth'])) 
{
  header('HTTP/1.1 403 Forbidden');
  exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Page</title>
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
				<li><a href="logout.php" accesskey="1" title="">Log Out</a></li>
			</ul>
		</div>
	</div>
	<div id="page">
	  <div id="content">
<?php
	include "connect.php";
	if (count($_FILES)>0){
		$course = $_FILES['coursesfile'];
		$reg = $_FILES['regfile'];
		
		if ($course['error']!=0 || $reg['error']!=0){
			die('Error Uploading Files.');
		} 
		else 
		{
			$fh = fopen($course['tmp_name'], 'r');
			$k=0;
			$sql = "INSERT INTO courses (dept, course_number, section_number, course_title, prereqs, netid, num_spn, room_size) VALUES";
			while ($line = str_replace("\n", "", str_replace("\r", "", fgets($fh))))
			{
				$values = explode("|", $line);
				//check to see if this record already exists
				$check1 = mysql_query("SELECT * FROM courses WHERE dept='{$values[0]}' AND course_number='{$values[1]}' AND section_number='{$values[2]}'");
				if (mysql_num_rows($check1)>0){
					//requires updating, not inserting
					mysql_query("UPDATE courses SET course_title ='{$values[3]}', prereqs = '{$values[4]}', netid = '{$values[5]}', num_spn = '{$values[6]}', room_size = '{$values[7]}' WHERE dept='{$values[0]}' AND course_number='{$values[1]}' AND section_number='{$values[2]}'")or die(mysql_error());
				} else {
					if ($k!=0)
					{
						$sql .= ",\n";
					} 
					else 
					{
						$sql .= "\n";
					}
					$k++;
					$sql .= "('".implode("', '", $values)."')";
					$k++;
				}
			}
			//only run the insert query if there are rows to insert
			if ($k!=0){
				mysql_query($sql) or die(mysql_error());
			}
			$fh = fopen($reg['tmp_name'], 'r');
			$k=0;
			$sql = "INSERT INTO registration(ruid, dept, course_number, section_number, grade) VALUES";
			while ($line = str_replace("\n", "", str_replace("\r", "", fgets($fh))))
			{
				$values = explode("|", $line);
				//check to see if this record already exists
				$check1 = mysql_query("SELECT * FROM registration WHERE ruid='{$values[0]}' AND dept='{$values[1]}' AND course_number='{$values[2]}' AND section_number='{$values[3]}'");
				if (mysql_num_rows($check1)>0){
					//requires updating, not inserting
					mysql_query("UPDATE registration SET grade = '{$values[4]}' WHERE ruid='{$values[0]}' AND dept='{$values[1]}' AND course_number='{$values[2]}' AND section_number='{$values[3]}'")or die(mysql_error());
				} else {
					if ($k!=0)
					{
						$sql .= ",\n";
					} 
					else 
					{
						$sql .= "\n";
					}
					$k++;
					$sql .= "('".implode("', '", $values)."')";
					$k++;
				}
			}
			//only run the insert query if there are rows to insert
			if ($k!=0){
				mysql_query($sql) or die(mysql_error());
			}
			echo "{$course['name']} and {$reg['name']} have been successfully inserted/updated.<br><br>";
		}
	}
?>		
		<form action="" method="post" enctype="multipart/form-data">
			<label for="coursesfile">Courses File:</label>
			<input type="file" name="coursesfile" id="file"><br>
			<label for="regfile">Registration/Grades File:</label>
			<input type="file" name="regfile" id="file"><br>			
			<input type="submit" name="submit">
		</form>
		</div>
		</div>
	</body>
</html>