<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View_Requests1.php</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
	<link href="students.css" rel="stylesheet" type="text/css" media="all" />
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
			
			
				view_requests();
				break;
	
	echo '
		</body>
	</html> ';

	function view_requests()
	{
		session_start();
		include 'connect.php';
		$netid = $_SESSION['netID'];
		$select_requests = mysql_query("SELECT * FROM course_requests WHERE netid='$netid'");
		echo '
					<div id="menu">
						<ul>
							<li><a href="studentwelcome.php" accesskey="1" title="">Back to Welcome Screen</a></li>
							<li><a href="Request_Page1.php" accesskey="2" title="">Request SPN numbers</a></li>
							<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
					</ul>
				</div>
			</div>
			<div id="page2">
				<h2 align="center">Course Requests (Click a request for more info or to delete it)</h2><br>
			  <div id="content2">
					<table width="70%" align="center" border="1" cellpadding="0" cellspacing="0"> 
			
						<tr>
							<td align="center"><i><b>Course Title</b></i></td>
							<td align="center"><i><b>Dept</b></i></td>
							<td align="center"><i><b>Course</b></i></td>
							<td align="center"><i><b>Sec</b></i></td>
							<!--<td align="center"><i><b>Explanation</b></i></td> -->
							<td align="center"><i><b>Submission Time</b></i></td>
							<td align="center"><i><b>Request Status </b></i> </td>
							<!--<td align="center"><i><b>Special Permission Number (if applicable)</b> </i></td>
							<td align="center"><i><b>Expiration Date of SPN (if applicable)</b></i></td> -->
						</tr> ';
						
				while($row = mysql_fetch_array($select_requests))
						{
							
							$_SESSION['requestdept'] = $row['dept'];
							$_SESSION['request_course_number'] = $row['course_number'];
							$_SESSION['request_section_number'] = $row['section_number'];
							$_SESSION['request_course_title'] = $row['course_title'];
							$_SESSION['request_explanation'] = $row['explanation'];
							$_SESSION['request_submissiontime'] = $row['submission_time'];
							$_SESSION['request_status'] = $row['status'];
							$_SESSION['request_special_permission'] = $row['special_permission_number'];
							$_SESSION['request_exp_date'] = $row['exp_date'];
							if($_SESSION['request_status'] == "-1"){
								$_SESSION['request_status'] = "Processing";
							}
							else if($_SESSION['request_status'] == "0"){
								$_SESSION['request_status'] = "Denied";
							}
							else if($_SESSION['request_status'] == "1"){
								$_SESSION['request_status'] = "Approved";
							}
							//$_SESSION['request_exp_date'] = $row['exp_date'];
							echo '<tr onmouseover="ChangeColor(this, true);" onmouseout="ChangeColor(this, false);" onclick=window.location.href="View_Requests2.php?dept=' . $row['dept'] . '&course_number=' . $row['course_number'] . '&section_number=' . $row['section_number'] . '">';
							//onclick=location.href="View_Requests2.php">';
								echo "<td>" . $row['course_title'] . "</td>";
								echo "<td>". $row['dept'] ."</td>";
								echo "<td>" . $row['course_number'] . "</td>";
								echo "<td>" . $row['section_number'] . "</td>";
								//echo "<td>" . $_SESSION['request_explanation'] . "</td>";
								echo "<td>" . $row['submission_time'] . "</td>";
								echo "<td>" . $_SESSION['request_status'] . "</td>";
								//echo "<td>" . $_SESSION['request_special_permission'] . "</td>";
								//echo "<td>" . $_SESSION['request_exp_date'] . "</td>";
							echo '</tr>';
						}
				
						
		echo '</table>
				</div>
			</div> ';
	}
	?>