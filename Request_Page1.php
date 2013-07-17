<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Request SP (1)</title>
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
                    <li><a href="logout.php" accesskey="4" title="">Cancel and Log Out</a></li>
                </ul>
            </div>
    </div>
    <?php
        include "connect.php";
        session_start();
        $sql = "SELECT DISTINCT dept FROM courses;";
        global $result;
		global $courseSelected;
        $result = mysql_query($sql);
        $welcome = "studentwelcome.php";
	 $numrows = mysql_num_rows($result);
	//$numrows = 0;
        if($numrows==0)
            {
            echo "<br><CENTER>An error occurred, there are no classes in the database  <BR> <A HREF=$welcome>Click here</A> to return to welcome page.</CENTER>";
            }
    
     else{   
     	echo "<div style='margin: 50px'>
        	<table width='696'>
            	<tr>
                	<td width='260'>
                    	<div style='margin: 50px'>
                        Select Department Number
                        </div>
                     </td>
                     <td width='424'>
                     
                     	<div style='margin:50px'>
                        <form name='form1' action='Request_Page1a.php' method='post' >
                        <select name='deptdropdown'>";
                        
                    	while($dept = mysql_fetch_array($result)){
                       		echo "<option value='".$dept['dept'] . "'>" . $dept['dept'] . "</option>";
                    	}
  	                	
                       echo "</select>
                        <input type='submit' name='submit1' value='Confirm Department'/>
                        </form>
                        </div>
                        </td>
                 </tr>
            	<tr>
            		<td width='260'>
              			<div style='margin: 50px'>
                        Select Course
                        </div>
              		</td>
              		<td width='424'>
                    </td>
              </tr>
              <tr>
              		<td>
              			<div style='margin: 50px'>
                        Select Section
                        </div>
                    </td>
              		<td>
             		 </td>
              </tr>
              <tr>
              		<td width='25%'>
             		</td>
              		<td align='center' width='50%'>
              		</td>
                    <td width='25%'>
                    </td>
              </tr>
          </table>
      </div>     
    </div>";
} ?>
</body>
</html>