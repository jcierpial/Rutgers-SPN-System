<?php

	SESSION_start();
	
	if ($_SESSION['auth']!=2) 
	{
	  header('HTTP/1.1 403 Forbidden');
	  exit();
	}
	
?>

<head>
	<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
	<link href="students.css" rel="stylesheet" type="text/css" media="all" />
	<title>SPN Manager</title>
	
	<script type="text/javascript">
		function ChangeColor(tableRow, highLight)
		{
		  if(highLight)
		  {
		    tableRow.style.backgroundColor = '#dcfac9';
		  }
		  else
		  {
		    tableRow.style.backgroundColor = 'white';
		  }
		}
		
	</script>
</head>

<?php

	echo '
		<html>
			<body>
				<div id="header">
					<div id="logo">
						<img src="rutgers_logo.jpg" width="390" height="150" alt="" />
					</div> ';
			
			switch ($_GET['mode'])
			{
				case "0":
				  welcome();
				  break;
				case "1":
				  select_courses();
				  break;
				case "2":
				  select_users();
				  break;
				case "3":
					add_class();
				  break;
				case "4":
					insert_course();
					break;
				case "5":
					course_info();
					break;
				case "6":
					update_course();
					break;
				case "7":
					delete_course();
					break;
				case "8":
					select_requests();
					break;
				case "9":
					manage_request();
					break;
				case "10":
					under_construction();
					break;
				case "11":
					accept();
					break;
				case "12":
					deny();
					break;
				case "13";
					send_message_all();
					break;
				case "14";
					send_message_one();
					break;
				case "15";
					message_all();
					break;
				case "16";
					message_one();
					break;
				case "17";
					enter_spn();
					break;
				case "18";
					verify_spn();
					break;
				case "19";
					select_best_fit();
					break;
				default:
					under_construction();
			}
	
	echo '
		</body>
	</html> ';

	function welcome()
	{
		echo '
				<div id="menu">
					<ul>
						<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=1" accesskey="1" title="">View Courses</a></li>
						<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
					</ul>
				</div>
			</div>
			<div id="page">
			  <div id="content">
		  		<h2> Welcome '. $_GET['netid'] . '!</h2>
					<p>The links above will help you assign your students special permission numbers!</p>
				</div>
			</div> ';
	}

	function select_courses()
	{
		include 'connect.php';
		
		$select_courses = mysql_query("SELECT * FROM courses WHERE netid ='" . $_GET['netid'] . "'", $link);
		
		echo '
					<div id="menu">
					<ul>
						<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=3" accesskey="2" title="">Add Class</a></li>
						<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=0" accesskey="1" title="">Back</a></li>
						<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
					</ul>
				</div>
			</div>
			<div id="page2">
				<h2 align="center">Courses</h2><br>
			  <div id="content2">
					<table width="60%" align="center" border="1" cellpadding="0" cellspacing="0"> 
			
						<tr>
							<td align="center"><i><b>Course Title</b></i></td>
							<td align="center"><i><b>Department</b></i></td>
							<td align="center"><i><b>Course</b></i></td>
							<td align="center"><i><b>Section #</b></i></td>
							<td align="center"><i><b>Room Capacity</b></i></td>
							<td align="center"><i><b>Already Registered</b></i></td>
							<td align="center"><i><b>Number of SPNs</b></i></td>
							<td align="center"><i><b>Prerequisites</b></i></td>
							<td align="center"><i><b>Number of Requests</b></i></td>
						</tr> ';
			
						while($row = mysql_fetch_array($select_courses))
						{
							$alreadyreg = mysql_query("SELECT * FROM registration R WHERE R.dept = {$row['dept']} AND R.course_number = {$row['course_number']} AND R.section_number = {$row['section_number']}", $link) or die(mysql_error());
							$prereqs = "None";
							
							while($alreadyregrow = mysql_fetch_array($alreadyreg))
								if(mysql_num_rows(mysql_query("SELECT * FROM course_requests CR WHERE CR.dept={$row['dept']} AND CR.course_number={$row['course_number']} AND CR.section_number={$row['section_number']} AND CR.status=-1 AND CR.ruid = {$alreadyregrow['ruid']}",$link)) == 1) 
									mysql_query("UPDATE course_requests CR SET CR.status = 2 WHERE CR.dept={$row['dept']} AND CR.course_number={$row['course_number']} AND CR.section_number={$row['section_number']} AND CR.status=-1 AND CR.ruid = {$alreadyregrow['ruid']}",$link) or die(mysql_error());
							
							if($row['prereqs'] != "")
								$prereqs = $row['prereqs'];
							
							$spn_num_requests = mysql_query("SELECT * FROM course_requests CR WHERE CR.dept={$row['dept']} AND CR.course_number={$row['course_number']} AND CR.section_number={$row['section_number']} AND CR.status=-1", $link) or die(mysql_error());
							$spn_num = mysql_num_rows($spn_num_requests);
							echo '<tr onmouseover="ChangeColor(this, true);" onmouseout="ChangeColor(this, false);" onclick=window.location.href="test.php?netid=' . $_GET['netid'] . '&dept=' . $row['dept'] . '&course_number=' . $row['course_number'] . '&section_number=' . $row['section_number'] . '&mode=5">';
								echo '<td>&nbsp&nbsp' . $row['course_title'] . '</td>';
								echo '<td>&nbsp&nbsp' . $row['dept'] . '</td>';
								echo '<td>&nbsp&nbsp' . $row['course_number'] . '</td>';
								echo '<td>&nbsp&nbsp' . $row['section_number'] . '</td>';
								echo '<td>&nbsp&nbsp' . $row['room_size'] . '</td>';
								echo '<td>&nbsp&nbsp' . get_num_registered($row['dept'], $row['course_number'], $row['section_number']) . '</td>';
								echo '<td>&nbsp&nbsp' . $row['num_spn'] . '</td>';
								echo '<td>&nbsp&nbsp' . $prereqs . '</td>';
								echo '<td>&nbsp&nbsp' . $spn_num . '</td>';
							echo '</tr>';
						}
						
		echo '</table>
				</div>
			</div> ';
	}
	
	function get_num_registered($dept, $course_number, $section_number)
	{
		include 'connect.php';
				
		$select_registered = mysql_query("SELECT * FROM registration WHERE grade='R' AND dept='" . $dept . "' AND course_number='" . $course_number . "' AND section_number='" . $section_number . "'", $link);
		$num = 0;
		
		while($row = mysql_fetch_array($select_registered))
			$num = $num + 1;
		
		return $num;
	}
	
	function add_class()
	{
			echo '
					<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=1" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> 
		
		<div id="page2">
			<h2 align="center">Add Class</h2><br>
			<div id="content2">
				<form name="add" action="test.php" method="get">
				
					<input type="hidden" name="netid" value="' . $_GET['netid'] . '">
					<input type="hidden" name="mode" value="4">
					
					<table align="center">
						<tr>
							<td>Course Title:</td><td><input type="text" name="course_title"></td>
						</tr>
						<tr>
							<td>Department:</td><td><input type="text" name="dept"></td>
						</tr>
						<tr>
							<td>Course Number:</td><td><input type="text" name="course_number"></td>
						</tr>
						<tr>
							<td>Section Number:</td><td><input type="text" name="section_number"></td>
						</tr>
						<tr>
							<td>Room Capacity:</td><td><input type="text" name="room_size"></td>
						</tr>
						<tr>
							<td>Number of SPNs:</td><td><input type="text" name="num_spn"></td>
						</tr>
						<tr>
							<td>Prerequisites:</td><td><input type="text" name="prereqs"></td>
						</tr>
						<tr><td><br></td></tr>
						<tr align="right"><td colspan="2"><input type="submit" value="Submit"></td></tr>
					</table>
					
				</form> 
			</div>
		</div> ';
	}
	
	function insert_course()
	{
		include 'connect.php';
		
		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=1" accesskey="1" title="">View Courses</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> ';
	
		if(mysql_query("INSERT INTO courses(dept, course_number, section_number, course_title, prereqs, netid, room_size, num_spn) VALUES('" . $_GET['dept'] . "','" . $_GET['course_number'] . "','" . $_GET['section_number'] . "','" . $_GET['course_title'] . "','" . $_GET['prereqs'] . "','" . $_GET['netid'] . "','" . $_GET['room_size'] . "','" . $_GET['num_spn'] . "')", $link))
		{
			echo '		
				<div id="page">
				  <div id="content">
			  		<h2> Success! </h2>
			  		<p>The course, '. $_GET['course_title'] . ', has been added.</p>
					</div>
				</div> ';
		}
		else
		{
			echo '
				<div id="page">
				  <div id="content">
			  		<h2> Sorry! </h2>
						<p>The course, '. $_GET['course_title'] . ', has not been added.</p>
					</div>
				</div> ';
		}
	}
	
	function course_info()
	{
		include 'connect.php';
		$select_class = mysql_query("SELECT * FROM courses c WHERE c.dept='" . $_GET['dept'] . "' AND c.course_number='" . $_GET['course_number'] . "' AND c.section_number='" . $_GET['section_number'] . "'", $link);
		$row = mysql_fetch_array($select_class);
		
		echo '
					<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=8&dept=' . $_GET['dept'] . '&course_number=' . $_GET['course_number'] . '&section_number=' . $_GET['section_number'] . '" accesskey="1" title="">View Requests</a></li>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&dept=' . $row['dept'] . '&course_number=' . $row['course_number'] . '&section_number=' . $row['section_number'] . '&mode=7">Delete</a></li>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=1" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> 
	
		<div id="page2">
			<h2 align="center">'. $row['course_title'] .'</h2><br>
			<div id="content2">
				<form name="add" action="test.php" method="get">
				
					<input type="hidden" name="netid" value="' . $_GET['netid'] . '">
					<input type="hidden" name="mode" value="6">
					
					<table align="center">
						<tr>
							<td>Course Title:</td><td><input type="text" name="course_title" value="' . $row['course_title'] . '" readonly></td>
						</tr>
						<tr>
							<td>Department:</td><td><input type="text" name="dept" value=' . $row['dept'] . ' readonly></td>
						</tr>
						<tr>
							<td>Course Number:</td><td><input type="text" name="course_number" value=' . $row['course_number'] . ' readonly></td>
						</tr>
						<tr>
							<td>Section Number:</td><td><input type="text" name="section_number" value=' . $row['section_number'] . ' readonly></td>
						</tr>
						<tr>
							<td>Room Capacity:</td><td><input type="text" name="room_size" value=' . $row['room_size'] . '></td>
						</tr>
						<tr>
							<td>Number of SPNs:</td><td><input type="text" name="num_spn" value=' . $row['num_spn'] . '></td>
						</tr>
						<tr>
							<td>Prerequisites:</td><td><input type="text" name="prereqs" value=' . $row['prereqs'] . '></td>
						</tr>
						<tr><td><br></td></tr>
						<tr align="right"><td align="right" colspan="2"><input type="submit" value="Update"></td></tr>
					</table>
					
				</form> 
			</div>
		</div> ';
	} 

	function update_course()
	{
		include 'connect.php';
		
		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=1" accesskey="1" title="">View Courses</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> ';
	
		if(mysql_query("UPDATE courses SET room_size=" . $_GET['room_size'] . ", num_spn='" . $_GET['num_spn'] . "', prereqs='" . $_GET['prereqs'] . "' WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link))
		{
			echo '		
				<div id="page">
				  <div id="content">
			  		<h2> Success! </h2>
			  		<p>The course, '. $_GET['course_title'] . ', has been updated.</p>
					</div>
				</div> ';
		}
		else
		{
			echo '
				<div id="page">
				  <div id="content">
			  		<h2> Sorry! </h2>
						<p>The course, '. $_GET['course_title'] . ', has not been updated.</p>
					</div>
				</div> ';
		}
	}
	
	function delete_course()
	{
		include 'connect.php';
		
		$select_class = mysql_query("SELECT * FROM courses c WHERE c.dept='" . $_GET['dept'] . "' AND c.course_number='" . $_GET['course_number'] . "' AND c.section_number='" . $_GET['section_number'] . "'", $link);
		$row = mysql_fetch_array($select_class);
		
		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=1" accesskey="1" title="">View Courses</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> ';
		
		if(mysql_query("DELETE FROM courses WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link))
		{
			echo '		
				<div id="page">
				  <div id="content">
			  		<h2> Success! </h2>
			  		<p>The course, '. $row['course_title'] . ', has been deleted.</p>
					</div>
				</div> ';
		}
		else
		{
			echo '
				<div id="page">
				  <div id="content">
			  		<h2> Sorry! </h2>
						<p>The course, '. $row['course_title'] . ', has not been deleted.</p>
					</div>
				</div> ';
		}
	}
	
	function select_requests()
	{
		include 'connect.php';
		
		$select_requests = mysql_query("SELECT * FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link);
		$select_class = mysql_query("SELECT * FROM courses c WHERE c.dept='" . $_GET['dept'] . "' AND c.course_number='" . $_GET['course_number'] . "' AND c.section_number='" . $_GET['section_number'] . "'", $link);
		$class = mysql_fetch_array($select_class);
		$numResults = mysql_num_rows($select_requests);
		
		$remaining_spots = $class['room_size'] - get_num_registered($class['dept'], $class['course_number'], $class['section_number']) - $class['given'];
		
		echo '
						<div id="menu">
					<ul>
						<li><a href="' . select_best_fit() . '" accesskey="1" title="">Select Best Fit</a></li>
						<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=15&dept=' . $_GET['dept'] . '&course_number=' . $_GET['course_number'] . '&section_number=' . $_GET['section_number'] . '" accesskey="1" title="">Message All</a></li>
						<li><a href="test.php?netid=' . $_GET['netid'] . '&dept=' . $class['dept'] . '&course_number=' . $class['course_number'] . '&section_number=' . $class['section_number'] . '&mode=5" accesskey="1" title="">Back</a></li>
						<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
					</ul>
				</div>
			</div>
			<div id="page2">
				<h2 align="center">Requests For ' . $class['course_title'] . '</h2><br>
				<h2 align="center">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Remaining Spots:&nbsp&nbsp&nbsp' . $remaining_spots . '</h2><br>
				<h2 align="center">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Remaining Numbers:&nbsp&nbsp&nbsp' . $class['num_spn'] . '</h2><br>';
			  	if($numResults > 0)
					{
						echo '
						<div id="content2">
							<table width="60%" align="center" border="1" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center"><i><b>Student Name</b></i></td>
									<td align="center"><i><b>RUID</b></i></td>
									<td align="center"><i><b>NetID</b></i></td>
									<td align="center"><i><b>Email</b></i></td>
									<td align="center"><i><b>Submission-Time</b></i></td>
									<td align="center"><i><b>Status</b></i></td>
								</tr> ';
							while($row = mysql_fetch_array($select_requests))
							{
									echo '<tr onmouseover="ChangeColor(this, true);" onmouseout="ChangeColor(this, false);" onclick=window.location.href="test.php?netid=' . $_GET['netid'] . '&request_id=' . $row['requestid'] . '&mode=9">';
									echo '<td>&nbsp&nbsp' . $row['name'] . '</td>';
									echo '<td>&nbsp&nbsp' . $row['ruid'] . '</td>';
									echo '<td>&nbsp&nbsp' . $row['netid'] . '</td>';
									echo '<td>&nbsp&nbsp' . $row['email'] . '</td>';
									echo '<td>&nbsp&nbsp' . $row['submission_time'] . '</td>';
									
									if($row['status'] == -1)
										echo '<td>&nbsp&nbsp Pending</td>';
									else if($row['status'] == 0)
										echo '<td>&nbsp&nbsp Denied</td>';
									else if($row['status'] == 1)
										echo '<td>&nbsp&nbsp Accepted</td>';
									else
										echo '<td>&nbsp&nbsp Already enrolled in course</td>';
						
								echo '</tr>';
							}
				echo '</table>
						</div> ';
						}
						else
						{
							echo '<p align="center">Sorry, no requests have been found.</p>';
						}
		echo '</div>';
	}

	function select_best_fit()
	{
		include 'connect.php';
		
		$top_score = 0;
		$top_request_id = "";
		
		$select_requests2 = mysql_query("SELECT * FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link);
		while($row1 = mysql_fetch_array($select_requests2))
		{
			if($row1['status'] == -1)
			{
				if($row1['gpa'] == 4.0)
					mysql_query("UPDATE course_requests SET score = score + 10 WHERE requestid = '" . $row1['requestid'] . "'", $link);
				else if($row1['gpa'] > 3.0)
					mysql_query("UPDATE course_requests SET score = score + 7 WHERE requestid = '" . $row1['requestid'] . "'", $link);
				else if($row1['gpa'] > 2.0)
					mysql_query("UPDATE course_requests SET score = score + 4 WHERE requestid = '" . $row1['requestid'] . "'", $link);
				else if($row1['gpa'] > 1.0)
					mysql_query("UPDATE course_requests SET score = score + 1 WHERE requestid = '" . $row1['requestid'] . "'", $link);
				else
					mysql_query("UPDATE course_requests SET score = score + 1 WHERE requestid = '" . $row1['requestid'] . "'", $link);
				
				if($row1['is_required'] == 1)
					mysql_query("UPDATE course_requests SET score = score + 5 WHERE requestid = '" . $row1['requestid'] . "'", $link);
				
				if($row1['is_retaking'] == 0)
					mysql_query("UPDATE course_requests SET score = score + 5 WHERE requestid = '" . $row1['requestid'] . "'", $link);
				
				if($row1['grad_year'] == 2014)
					mysql_query("UPDATE course_requests SET score = score + 5 WHERE requestid = '" . $row1['requestid'] . "'", $link);
			}
		}
		
		$select_requests1 = mysql_query("SELECT * FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link);
		while($row2 = mysql_fetch_array($select_requests1))
		{
			if(($row2['status'] == -1 OR $row2['status'] == 0) AND $row2['score'] >= $top_score)
			{
				$top_score = $row2['score'];
				$top_request_id = $row2['requestid'];
			}
		}
		
		$select_requests3 = mysql_query("SELECT * FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link);
		while($row3 = mysql_fetch_array($select_requests3))
			mysql_query("UPDATE course_requests SET score = 0 WHERE requestid = '" . $row3['requestid'] . "'", $link);
		
		if($top_request_id == "")
			return "test.php?netid=" . $_GET['netid'] . "&mode=8&dept=" . $_GET['dept'] . "&course_number=" . $_GET['course_number'] . "&section_number=" . $_GET['section_number'];
		else
			return "test.php?netid=" . $_GET['netid'] . "&request_id=" . $top_request_id . "&mode=9";
	}

	function under_construction()
	{	
			echo '	
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=1" accesskey="1" title="">View Courses</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div>	
		<div id="page">
		  <div id="content">
	  		<h2> Under Construction... </h2>
			</div>
		</div> ';
	}
	
	function manage_request()
	{
		include 'connect.php';
		
		if(count($_GET) == 4)
		{
			$comments = mysql_real_escape_string($_GET['comments']);
			$sql = "UPDATE course_requests SET comments = '{$comments}' WHERE requestid={$_GET['request_id']}";
			$result = mysql_query($sql) or die(mysql_error());
		}
		
		$select_request = mysql_query("SELECT * FROM course_requests WHERE requestid='" . $_GET['request_id'] . "'", $link);
		$request = mysql_fetch_array($select_request);
		
		$select_class = mysql_query("SELECT * FROM courses c WHERE c.dept='" . $request['dept'] . "' AND c.course_number='" . $request['course_number'] . "' AND c.section_number='" . $request['section_number'] . "'", $link);
		$class = mysql_fetch_array($select_class);
		
		$remaining_spots = $class['room_size'] - get_num_registered($select_request['dept'], $select_request['course_number'], $select_request['section_number']) - $class['given'];

		
		if($request['is_retaking'] == 0)
			$is_retaking = 'No';
		else
			$is_retaking = 'Yes';
		
		if($request['is_required'] == 0)
			$is_required = 'No';
		else
			$is_required = 'Yes';
		
		echo '	
			<div id="menu">
				<ul> ';
				
				if($remaining_spots > 0)
				{
					if($request['status'] == -1)
					{
						echo'
							<li><a href="test.php?netid=' . $_GET['netid'] . '&request_id=' . $request['requestid'] . '&mode=17" accesskey="1" title="">Accept</a></li>
							<li><a href="test.php?netid=' . $_GET['netid'] . '&request_id=' . $request['requestid'] . '&mode=12" accesskey="1" title="">Deny</a></li> ';
					}
					else if($request['status'] == 0)
						echo '<li><a href="test.php?netid=' . $_GET['netid'] . '&request_id=' . $request['requestid'] . '&mode=17" accesskey="1" title="">Accept</a></li>';
				}
				else
				{
					if($request['status'] == -1)
					{
						echo'
							<li><a href="test.php?netid=' . $_GET['netid'] . '&request_id=' . $request['requestid'] . '&mode=12" accesskey="1" title="">Deny</a></li> ';
					}
				}	
			echo '
					<li><a href="test.php?netid=' . $_GET['netid'] . '&request_id=' . $request['requestid'] . '&mode=16" accesskey="1" title="">Message</a></li>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=8&dept=' . $request['dept'] . '&course_number=' . $request['course_number'] . '&section_number=' . $request['section_number'] . '" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div>	
		<div id="page2">
		  <div id="content2">
	  		<h2 align="center"> ' . $request['name'] . '&nbsp&nbsp&nbsp&nbsp - &nbsp&nbsp&nbsp&nbsp';
  			if($request['status'] == 1)
						echo'Accepted</h2>';
				else if($request['status'] == -1)
						echo'Pending</h2>';
				else if($request['status'] == 0)
						echo'Denied</h2>';
				else
						echo'Already Enrolled</h2>';

	  		echo'
	  		<p align="center"><b>Student Explanation:</b><br> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ' . $request['explanation'] .  ' </p><br>
			<p align="center"><b>Additional Comments:</b><br>
			
			<form method="get" action="test.php" align="center">
				<center><textarea name="comments" cols=80 rows=8>'.$request['comments'].'</textarea></center><br>
				<input type="hidden" name="netid" value="' . $_GET['netid'] . '">
				<input type="hidden" name="request_id" value="' . $_GET['request_id'] . '">
				<input type="hidden" name="mode" value="9">
				<center><input type=submit value="Submit"></center>
			</form>

			</p><br>
	  		<form>';			
	  			echo '<table align="center"> ';
	  			
	  			if($request['status'] == 1)
						echo'<tr><td>Special Permission Number:&nbsp&nbsp&nbsp</td><td>' . $request['special_permission_number'] . '</td></tr></h2>';
						
	  			echo '
	  				<tr><td>GPA:</td><td>' . $request['gpa'] . '</td></tr>
	  				<tr><td>Graduation Year: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>' . $request['grad_year'] . '</td></tr>
	  				<tr><td>Major:</td><td>' . $request['major'] . '</td></tr>
	  				<tr><td>Retaking:</td><td>' . $is_retaking . '</td></tr>
	  				<tr><td>Required:</td><td>' . $is_required . '</td></tr>
					<tr><td>Prerequisites:&nbsp</td><td>' . $request['prereqs'] . '</td></tr>
	  			</table>
	  		</form>	
			</div>
		</div> ';
	}
	
	function accept()
	{
		include 'connect.php';
		
		$select_request = mysql_query("SELECT * FROM course_requests WHERE requestid='" . $_GET['request_id'] . "'", $link);
		$request = mysql_fetch_array($select_request);
		
		$select_class = mysql_query("SELECT * FROM courses c WHERE c.dept='" . $request['dept'] . "' AND c.course_number='" . $request['course_number'] . "' AND c.section_number='" . $request['section_number'] . "'", $link);
		$class = mysql_fetch_array($select_class);
		
		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=8&dept=' . $request['dept'] . '&course_number=' . $request['course_number'] . '&section_number=' . $request['section_number'] . '" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> ';
		
		if($class['num_spn'] > 0 && mysql_query("UPDATE course_requests SET status=1 WHERE requestid = '" . $_GET['request_id'] . "'", $link))
		{
			$SPN = $_GET['spn'];
			$expirationdate = date('Y-m-d', strtotime($_GET['expirationdate']));
			if ($expirationdate = 1969-12-31)
			{
				$expirationdate = date('Y-m-d',strtotime("+3 days"));
			}
			mysql_query("UPDATE course_requests SET special_permission_number='". $SPN . "', exp_date = '{$expirationdate}' WHERE requestid='" . $_GET['request_id'] . "'", $link) or die(mysql_error());
			mysql_query("UPDATE courses c SET c.num_spn = c.num_spn - 1 WHERE c.dept='" . $request['dept'] . "' AND c.course_number='" . $request['course_number'] . "' AND c.section_number='" . $request['section_number'] . "'", $link)or die(mysql_error());
			mysql_query("UPDATE courses c SET c.given = c.given + 1 WHERE c.dept='" . $request['dept'] . "' AND c.course_number='" . $request['course_number'] . "' AND c.section_number='" . $request['section_number'] . "'", $link)or die(mysql_error());
			
			echo '		
				<div id="page">
				  <div id="content">
			  		<h2> Success! </h2>
			  		<p>The student, ' . $request['name'] . ', has been given the special permission number: ' . $SPN . '<br>This special permission number expires: ' . $expirationdate . '</p>
					</div>
				</div> ';
		}
		else
		{
			echo '
				<div id="page">
				  <div id="content">
			  		<h2> Sorry! </h2>
						<p>The student, '. $request['name'] . ', has not been given a special permission number.</p>
					</div>
				</div> ';
		}
	}
	
	function enter_spn()
	{
		include 'connect.php';
		
		$select_request = mysql_query("SELECT * FROM course_requests WHERE requestid='" . $_GET['request_id'] . "'", $link);
		$request = mysql_fetch_array($select_request);
		
		$select_class = mysql_query("SELECT * FROM courses c WHERE c.dept='" . $request['dept'] . "' AND c.course_number='" . $request['course_number'] . "' AND c.section_number='" . $request['section_number'] . "'", $link);
		$class = mysql_fetch_array($select_class);
		
		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=9&dept=' . $request['dept'] . '&request_id=' . $request['requestid'] . '&course_number=' . $request['course_number'] . '&section_number=' . $request['section_number'] . '" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div>
		<div id="page">
			  <div id="content">
		  		<h2>Enter a special permission number
						<form method="get" action="test.php" align="center">
						
							<table align="center">
								<tr>
									<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSpecial Permission Number for ' . $request['name'] . ' : </td>
									<td><input type="text" name="spn"></td>
								</tr>
								<tr>
									<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSPN Expiration Date: <input type="date" name="expirationdate"></td>
								</tr>
								<tr>
									<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=submit value="Enter"></td>
								</tr>
								<br>
							</table><br>
		
							<input type="hidden" name="netid" value="' . $_GET['netid'] . '">
							<input type="hidden" name="request_id" value="' . $_GET['request_id'] . '">
							<input type="hidden" name="mode" value="18">
							
						</form> 
					</h2>
				</div>
		</div> ';
	}
	
	function verify_spn()
	{
	 	include 'connect.php';
		
		$select_request = mysql_query("SELECT * FROM course_requests WHERE requestid='" . $_GET['request_id'] . "'", $link);
		$request = mysql_fetch_array($select_request);
		
		$select_class = mysql_query("SELECT * FROM courses c WHERE c.dept='" . $request['dept'] . "' AND c.course_number='" . $request['course_number'] . "' AND c.section_number='" . $request['section_number'] . "'", $link);
		$class = mysql_fetch_array($select_class);
		
		$duplicate_spn = mysql_query("SELECT * FROM course_requests c WHERE c.special_permission_number='" . $_GET['spn'] . "' AND c.dept='" . $request['dept'] . "' AND c.course_number='" . $request['course_number'] . "' AND c.section_number='" . $request['section_number'] . "' AND c.exp_date > CURRENT_DATE()", $link);
		$duplicate = mysql_fetch_array($duplicate_spn);
		
		if($_GET['spn'] == "" || $duplicate || !is_numeric($_GET['spn']))
		{
			echo '
					<div id="menu">
						<ul>
							<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=17&request_id=' . $request['requestid'] . '" accesskey="1" title="">Back</a></li>
							<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
						</ul>
					</div>
				</div> 
				<div id="page">
				  <div id="content">
			  		<h2> Sorry! </h2>
						<p>The student, '. $request['name'] . ', has not been given a special permission number.<br>This is due to either a blank SPN # entered, the SPN # has already been assigned, or the SPN # was not properly entered.</p>
					</div>
				</div> ';
		}
		else
		{
			accept();
		}
	}
		
	function deny()
	{
		include 'connect.php';
		
		$select_request = mysql_query("SELECT * FROM course_requests WHERE requestid='" . $_GET['request_id'] . "'", $link);
		$request = mysql_fetch_array($select_request);

		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=8&dept=' . $request['dept'] . '&course_number=' . $request['course_number'] . '&section_number=' . $request['section_number'] . '" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> ';
		
		if(mysql_query("UPDATE course_requests SET status=0 WHERE requestid = '" . $_GET['request_id'] . "'", $link))
		{
				echo '		
				<div id="page">
				  <div id="content">
			  		<h2> Success! </h2>
			  		<p>The student, ' . $request['name'] . ', has been denied.</p>
					</div>
				</div> ';
			}
			else
			{
				echo '
					<div id="page">
					  <div id="content">
				  		<h2> Sorry! </h2>
							<p>The student, '. $request['name'] . ', has not been denied.</p>
						</div>
					</div> ';
			}
	}
	
	function send_message_all()
	{
		include 'connect.php';
		
		$problem = false;
		
		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=8&dept=' . $_GET['dept'] . '&course_number=' . $_GET['course_number'] . '&section_number=' . $_GET['section_number'] . '" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> ';
		
		$select_requests = mysql_query("SELECT * FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link);
		
		while($row = mysql_fetch_array($select_requests))
		{
			if(!mysql_query("INSERT INTO email VALUES (DEFAULT, '" . $row['email'] . "','" . $_GET['from'] . "','" . $_GET['subject'] . "','" . $_GET['message'] . "')", $link))
			{
				echo '
				<div id="page">
				  <div id="content">
			  		<h2> Sorry! </h2>
						<p>There was a problem sending the message to all students.</p>
					</div>
				</div> ';
				
				$problem = true;
				
				break;
			}
		}
		
		if(!$problem)
		{
			echo '		
				<div id="page">
				  <div id="content">
			  		<h2> Success! </h2>
			  		<p>Message sent to all students.</p>
					</div>
				</div> ';
		}
	}
	
	function send_message_one()
	{
		include 'connect.php';
	
		echo '
			<div id="menu">
				<ul>
					<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=9&request_id=' . $_GET['request_id'] . '" accesskey="1" title="">Back</a></li>
					<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
				</ul>
			</div>
		</div> ';

		if(mysql_query("INSERT INTO email VALUES (DEFAULT, '" . $_GET['to'] . "','" . $_GET['from'] . "','" . $_GET['subject'] . "','" . $_GET['message'] . "')", $link))
		{
			echo '		
			<div id="page">
			  <div id="content">
		  		<h2> Success! </h2>
		  		<p>Message sent.</p>
				</div>
			</div> ';
		}
		else
		{
			echo '
				<div id="page">
				  <div id="content">
			  		<h2> Sorry! </h2>
						<p>Message failed to send.</p>
					</div>
				</div> ';
		}
	}
	
	function message_all()
	{
		include 'connect.php';
		
		$select_requests = mysql_query("SELECT * FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND section_number='" . $_GET['section_number'] . "'", $link);
		$requests = mysql_fetch_array($select_request);
		
		$select_instructor = mysql_query("SELECT * FROM users WHERE netid='" . $_GET['netid'] . "'", $link);
		$instructor = mysql_fetch_array($select_instructor);
		
		$to = "";
		
		while($row = mysql_fetch_array($select_requests))
		{
			if($to == "")
				$to = $row['email'];
			else
				$to = $to . ';' . $row['email'];
		}
		
		echo '
				<div id="menu">
					<ul>
						<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=8&dept=' . $_GET['dept'] . '&course_number=' . $_GET['course_number'] . '&section_number=' . $_GET['section_number'] . '" accesskey="1" title="">Back</a></li>
						<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
					</ul>
				</div>
			</div> 		
			<div id="page2">
			  <div id="content2">
				  <form method="get" action="test.php">
				  
				  	<table>
				  		<tr><td>To: </td><td><input type="text" name="to" value="' . $to . '" readonly></td></tr>
				  		<tr><td>Subject: </td><td><input type="text" name="subject"></td></tr>
				  	</table><br>
				  	
				  	<input type="hidden" name="from" value="' . $instructor['email'] . '">
				  	<input type="hidden" name="netid" value="' . $_GET['netid'] . '">
				  	<input type="hidden" name="dept" value="' . $_GET['dept'] . '">
				  	<input type="hidden" name="course_number" value="' . $_GET['course_number'] . '">
				  	<input type="hidden" name="section_number" value="' . $_GET['section_number'] . '">
				  	<input type="hidden" name="mode" value="13">
				  	<textarea name="message" cols=100 rows=10></textarea><br>
						<input type=submit value="Send">
						
					</form>
				</div>
			</div> ';
	}
	
	function message_one()
	{
		include 'connect.php';
		
		$select_request = mysql_query("SELECT * FROM course_requests WHERE requestid='" . $_GET['request_id'] . "'", $link);
		$request = mysql_fetch_array($select_request);
		
		$select_instructor = mysql_query("SELECT * FROM users WHERE netid='" . $_GET['netid'] . "'", $link);
		$instructor = mysql_fetch_array($select_instructor);
		
		echo '
				<div id="menu">
					<ul>
						<li><a href="test.php?netid=' . $_GET['netid'] . '&mode=9&request_id=' . $request['requestid'] . '" accesskey="1" title="">Back</a></li>
						<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
					</ul>
				</div>
			</div> 		
			<div id="page2">
			  <div id="content2">
				  <form method="get" action="test.php">
				  	<table>
				  		<tr><td>To: </td><td><input type="text" name="to" value="' . $request['email'] . '" readonly></td></tr>
				  		<tr><td>Subject: </td><td><input type="text" name="subject"></td></tr>
				  	</table><br>
				  	<input type="hidden" name="from" value="' . $instructor['email'] . '">
				  	<input type="hidden" name="netid" value="' . $_GET['netid'] . '">
				  	<input type="hidden" name="mode" value="14">
				  	<input type="hidden" name="request_id" value="' . $_GET['request_id'] . '">
				  	<textarea name="message" cols=100 rows=10></textarea><br>
						<input type=submit value="Send">
					</form>
				</div>
			</div> ';
	}
	
?>
