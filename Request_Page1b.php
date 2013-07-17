<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Request SP # (1b)</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
    <?php
        include "connect.php";
        session_start();
		$course = $_POST['course'];
        $sql = "SELECT DISTINCT section_number FROM courses WHERE course_title='$course';";
        global $result;
        $result = mysql_query($sql);
    ?>
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
        
     <div style="margin: 50px">
     <form name="form1" action="Request_Page2.php" method="post" >
        	<table width="696">
            <tr>
            		<td width="260">
              			<div style=" margin: 50px">
                        Select Department Number
                        </div>
              		</td>
              		<td width="424">
              			<div style=" margin: 50px;">
                        <?php
							
						   echo $_SESSION['deptdropdown'];
						   ?>
              			</div>
                    </td>
              </tr>
            	
            	<tr>
            		<td width="260">
              			<div style=" margin: 50px">
                        Select Course
                        </div>
              		</td>
              		<td width="424">
              			<div style=" margin: 50px;">
                        <?php
							$_SESSION['coursedropdown'] = $_POST[course];
						   echo $_POST[course];
						   ?>
              			</div>
                    </td>
              </tr>
              <tr>
              		<td>
              			<div style=" margin: 50px">
                        Select Section
                        </div>
                    </td>
              		<td>
              			<div style=" margin: 50px">
					   <?php
                        echo "<select name='sectiondropdowns'>";
                        while($section = mysql_fetch_array($result)){
                           echo "<option value='".$section['section_number'] . "'>" . $section['section_number'] . "</option>";
                        }
                        echo "</select>";
                        ?>
              			</div>
             		 </td>
              </tr>
              <tr>
              		<td width="25%">
             		</td>
              		<td align="center" width="50%">
              		<input type="submit" name="registration1" value="Next page"/>
              		</td>
                    <td width="25%">
                    </td>
              </tr>
          </table>
          </form>

      </div>     
    </div>
</body>
</html>