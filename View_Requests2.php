<head>
	<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
	<link href="students.css" rel="stylesheet" type="text/css" media="all" />
	<title>View_Requests2</title>
	
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
				
				request_info();
				break;
	
	echo '
		</body>
	</html> ';
	
	function request_info()
	{
		session_start();
		include 'connect.php';
		$netid = $_SESSION['netID'];
		$_SESSION['request_to_delete'] = "DELETE FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND netid='$netid'" . " AND section_number='" . $_GET['section_number'] . "'";
		$sql = "SELECT * FROM course_requests WHERE dept='" . $_GET['dept'] . "' AND course_number='" . $_GET['course_number'] . "' AND netid='$netid'" . " AND section_number='" . $_GET['section_number'] . "'";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){ // SHOULD NEVER DISPLAY MULTIPLE BECAUSE CHECK FOR REQUESTS
			//echo "reaches here";
			if($row['status'] == "-1"){
					$row['status'] = "Processing";
			}
			else if($row['status'] == "0"){
					$row['status'] = "Denied";
			}
			else if($row['status'] == "1"){
					$row['status'] = "Approved";
			}
			else if($row['status'] == "2"){
					$row['status'] = "You are already registered for this course";
			}	
			if($row['status'] != "Approved"){
				$exp_date = "N/A";
				$sp = "N/A";
			}
			else{
				$exp_date = $row['exp_date'];
				$sp = $row['special_permission_number'];
			}
			if($row['explanation'] == ""){
				$row['explanation'] = "N/A";
			}
			//echo $row['status'];
		//echo "skips to here";
		echo '
					<div id="menu">
					<ul>
						<li><a href="studentwelcome.php" accesskey="1" title="">Back to Welcome Screen</a></li>
						<li><a href="View_Requests.php" accesskey="3" title="">View SPN Requests</a></li>
						<li><a href="logout.php" accesskey="4" title="">Log Out</a></li>
					</ul>
			</div>
		</div> 
	
		<div id="page2">
			<h2 align="center">Request Information</h2><br>
			<div id="content2">
				<form name="add" action="test.php" method="get">
				
					<input type="hidden" name="netid" value="' . $netID . '">
					<input type="hidden" name="mode" value="6">
					
					<table align="center">
						<tr>
							<td>Course Title:</td><td>' . $row['course_title'] . '</td>
						</tr>
						<tr>
							<td>Department:</td><td>' . $row['dept'] . '</td>
						</tr>
						<tr>
							<td>Course Number:</td><td>' . $row['course_number'] . '</td>
						</tr>
						<tr>
							<td>Section Number:</td><td>' . $row['section_number'] . '</td>
						</tr>
						<tr>
							<td>Explanation:</td><td>' . $row['explanation'] . '</td>
						</tr>
						<tr>
							<td>Submission Time:</td><td>' . $row['submission_time'] . '</td>
						</tr>
						<tr>
							<td>Status:</td><td>' . $row['status'] . '</td>
						</tr>
						<tr>
							<td>Special Permission Number:</td><td>' . $sp . '</td>
						</tr>
						<tr>
							<td>Expiration Date:</td><td>' . $exp_date . '</td>
						</tr>
						<tr><td align = "right"><br><a href="Delete_Request.php"> Delete Request </a></td></tr>
					</table>
					
				</form> 
			</div>
		</div> ';
		}
	} 
?>