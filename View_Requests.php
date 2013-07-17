<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update PHP</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all"  />
</head>
<body>
<?php
	include 'connect.php';
	session_start();
	$ruid = $_SESSION['ruid'];
	$netid = $_SESSION['netID'];
	$courses = mysql_query("SELECT c.prereqs, c.course_title, c.section_number FROM courses c, course_requests r WHERE c.course_title = r.course_title AND c.section_number = r.section_number AND c.prereqs IS NOT NULL"); // finds all the courses which have a course request
	while($row = mysql_fetch_array($courses)){ // goes through all the rows for each couse
		$course_title = $row['course_title'];
		$section_number = $row['section_number'];
		$prereq_string = $row['prereqs'];//String of prereqs from the curr_request
		//echo "prereq string 1 is '$prereq_string' <br>";
		$curr_request = mysql_query("SELECT * FROM course_requests WHERE course_title = '$course_title' AND section_number = '$section_number' AND netid = '$netid'");
		$donewithcourse = FALSE;
		//echo "reached this course query: SELECT * FROM course_requests WHERE course_title = '$course_title' AND section_number = '$section_number' AND netid = '$netid' <br>";
		while($temp = mysql_fetch_array($curr_request)){// only one row
			//echo "reaches here <br>";
			//echo "prereq string 2 is '$prereq_string' <br>";
			$prereq = strtok($prereq_string, " ,"); 
			$count = 0;
			$gradevar = "";
			while($prereq !== false && !($donewithcourse)){ //prereqs-198:112 //assuming all the data is entered correctly
				$reqdept = substr($prereq, 0, 3); //eg. 198
				$reqcourse = substr($prereq, -3);// eg. 112
				// Check if they failed the course
				$query2 = "SELECT * FROM registration WHERE dept = '$reqdept' AND course_number = '$reqcourse' AND ruid='$ruid'"; // sees if user has taken this prereq
				echo "Is at this prereq: '$reqdept':'$reqcourse' <br>";
				$check = mysql_query($query2); 
				if( mysql_num_rows($check) != 0 ){ // if he's taken the prereq
					while($temp2 = mysql_fetch_array($check)){ //should only be one (one prereq)
						//echo "Grade at this prereq is: " . $temp2['grade'];
						//echo "<br>Prereq is: $prereq <br>";
						if($gradevar == "" || $gradevar == "F"){
							$gradevar = $temp2['grade'];
							//echo "gradevar becomes F here <br>";
						}
					}
					if($gradevar == "F" || $gradevar=""){ //if it's an F. If it's not an F then it should go to next prereq.
						//echo "reaches here<br>";
						$donewithcourse = TRUE;
						$todelete = "DELETE FROM course_requests WHERE course_title = '$course_title' AND section_number = '$section_number' AND netid = '$netid'";
						$toquery = mysql_query($todelete);
						//drop course request
					}
				}
				else{ // if never taken the prereq
					$donewithcourse = TRUE;
					$todelete = "DELETE FROM course_requests WHERE course_title = '$course_title' AND section_number = '$section_number' AND netid = '$netid'";
					$toquery = mysql_query($todelete);
					}
				//echo "------ AT THE NEXT PREREQ ------- <br>";
				$gradevar = "";
				$count = $count+1;
				$prereq = strtok(" ,");
			}
			//echo "----- AT THE NEXT CLASS -----<br>";				
		}	
	}
	//echo "<a href='View_Requests.php'> Here you go continue </a>";
	header('Location: View_Requests1a.php');
	// for all courses in course requests
	
	
	?>
</body>
</html>