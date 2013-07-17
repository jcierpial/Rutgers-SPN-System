<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Check_Prereqs</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<?php
	/**
		Need to
			1) Pull out the course sent by request Page 1b. --- DONE
				1a) make a bool flag for all prereqs grades, isFailed default to false --- DONE
			2) Check the prereqs for this course, store in string. e.g. "198:112, 198:111" -- DONE
			3) Tokenize the string and store each number as a prereq variable - DONE
					4) for each prereq variable extract dept (first num), and course (second num) DONE
					5) Look up the grades for this prereq in the registered database where taken by student -- DONE
					6) If any grade == F, set a bool flag to true -- DONE
					6a) If not taken, set flag to true -- DONE
			7) If (isFailed)
				display error
		 	8) else
				 header( 'Location.....) redirect to Request page3.php - major info
	 **/
					
				
	include 'connect.php';
	session_start();
	$dept = $_SESSION['deptdropdown']; $course = $_SESSION['coursedropdown']; $ruid = $_SESSION['ruid']; 
	$_SESSION['sectiondropdown'] = $_POST[sectiondropdowns];
	$section = $_POST[sectiondropdowns]; $isFailed = FALSE; $hasPassed = FALSE; $redundant = FALSE; $registered = FALSE;
	$sql = mysql_query("SELECT * FROM courses WHERE section_number = '$section' AND course_title = '$course'"); // Class to schedule
	$_SESSION['prereq_grades'] = "";
	while($row = mysql_fetch_array($sql)) // The course wanting to schedule for
		{	
		
			// see if it's in the registration
			$course_num = $row['course_number'];
			$already_passed = mysql_query("SELECT * FROM registration WHERE dept = '$dept' AND course_number = '$course_num' AND grade <> 'F' AND ruid = '$ruid'");
			if(mysql_num_rows($already_passed) >= 1){
				$hasPassed = TRUE;
				break;
			}
			
			// see if it's already requested the section
			$multiple_reqs = mysql_query("SELECT * FROM course_requests WHERE dept = '$dept' AND course_number = '$course_num' AND ruid = '$ruid' AND section_number = '$section'");
			//echo $multiple_reqs;
			//echo "SELECT * FROM course_requests WHERE dept = '$dept' AND course_number = '$course_num' AND ruid = '$ruid' AND section_number = '$section'";
			if(mysql_num_rows($multiple_reqs) >= 1){
				//echo "reaches here";
				$redundant = TRUE;
				break;
			}
			
			$already_registered = mysql_query("SELECT * FROM registration WHERE dept = '$dept' AND course_number = '$course_num' AND section_number = '$' AND ruid = '$ruid' AND grade = 'R'");
			if(mysql_num_rows($already_registered) >= 1){
				$registered = TRUE;
				break;
			}
			$prereq_string = $row['prereqs'];//String of prereqs
			$prereq = strtok($prereq_string, " ,"); 
			$count = 0;
			$gradevar = "";
			while($prereq !== false){ // prereqs  e.g. 198:112 // assuming all the data is entered in correctly
				$reqdept = substr($prereq, 0, 3); //eg. 198
				$reqcourse = substr($prereq, -3);// eg. 112
				
				// Check if they failed the course
				$query2 = "SELECT * FROM registration WHERE dept = '$reqdept' AND course_number = '$reqcourse' AND ruid='$ruid'"; // sees if user has taken this prereq
				$check = mysql_query($query2); // query that taken thing
				if( mysql_num_rows($check) != 0 ){ // if he's taken the prereq
					while($temp = mysql_fetch_array($check)){ // For all the requests where the dept and course and user are the same			
						if($gradevar == "" || $gradevar == "F"){
							$gradevar = $temp['grade'];
						}
						//else do nothing, already passing
					}
					if($gradevar == "F" || $gradevar == ""){
						$isFailed = TRUE;
					}
					else{
						if($count == 0){
							$_SESSION['prereq_grades'] = $gradevar;
						}
						else{
							$_SESSION['prereq_grades'] = $_SESSION['prereq_grades'] . ",$gradevar";
						}
					}
				}
				else{ // if never taken the prereq
					$isFailed = TRUE;
				}
				$gradevar = "";
				$count = $count+1;
				$prereq = strtok(" ,");
			}
		}
	if($isFailed){
		echo " <div id='header'>
            <div id='logo'>
                <img src='rutgers_logo.jpg' width='400' height='150' />
            </div>
            <div id='menu'>
                <ul>
                    <li><a href='logout.php' accesskey='4' title=''>Cancel and Log Out</a></li>
                </ul>
            </div>
    </div>";
		echo "<br><CENTER> An error occured while trying to make this course request. Either you have not taken one or more of the prerequisites or you have failed one or more of the prerequisites and have not retaken and passed that prerequisite.<BR> Click <A HREF=studentwelcome.php>here</A> to go to the Student Welcome page.";
	}
	else if($hasPassed){
		echo " <div id='header'>
            <div id='logo'>
                <img src='rutgers_logo.jpg' width='400' height='150' />
            </div>
            <div id='menu'>
                <ul>
                    <li><a href='logout.php' accesskey='4' title=''>Cancel and Log Out</a></li>
                </ul>
            </div>
    </div>";
		echo "<br><CENTER> An error occured while trying to make this course request. You have already passed  or are currently enrolled in this class.<BR> Click<A HREF=studentwelcome.php> here</A> to go to the Student Welcome page.";	
	}
	else if($redundant){
		echo " <div id='header'>
            <div id='logo'>
                <img src='rutgers_logo.jpg' width='400' height='150' />
            </div>
            <div id='menu'>
                <ul>
                    <li><a href='logout.php' accesskey='4' title=''>Cancel and Log Out</a></li>
                </ul>
            </div>
    </div>";
		echo "<br><CENTER> An error occured while trying to make this course request. You have already requested this class and section.<BR> Click<A HREF=studentwelcome.php> here</A> to go to the Student Welcome page.";	
	}
	else if($registered){
		echo " <div id='header'>
            <div id='logo'>
                <img src='rutgers_logo.jpg' width='400' height='150' />
            </div>
            <div id='menu'>
                <ul>
                    <li><a href='logout.php' accesskey='4' title=''>Cancel and Log Out</a></li>
                </ul>
            </div>
    </div>";
		echo "<br><CENTER> An error occured while trying to make this course request. You are already currently registered for this class and section.<BR> Click<A HREF=studentwelcome.php> here</A> to go to the Student Welcome page.";	
		
	}
	else{
		echo $_SESSION['prereq_grades'];
		header('Location: Request_Page3.php');	
	}
 ?>
</body>
</html>
