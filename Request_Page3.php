<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Request_Page3</title>
<link href="http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet" type="text/css" />
<link href="students.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
	function validate(){
		var error = "You are messing up the following fields.\nPlease make sure to fill them \nbefore submitting again: \n \n";
		var ismissing = false;
		if(document.finalform.gpa.value == ""){
			ismissing = true;
			error = error + "gpa \n";
		}
		else if(document.finalform.major.value == ""){
			ismissing = true;
			error = error + "major \n";
		}
		else if(document.finalform.gradyear.value == ""){
			ismissing = true;
			error = error + "graduation year \n";
		}
		if(ismissing){
			alert(error);
			return false;
		}else{
			//document.form1.submit();
			return true;
		}
	}
</script>
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
    ?>
        
     <div style="margin: 50px">
     <form name="finalform" action="Request_Page4.php" method="post" onsubmit="return validate()">
        	<table width="696">
            <tr> 
            	<td>
                	<div>
                    	Please select the appropriate information for the following fields
                        </div>
                </td>
            </tr>
            <tr>
            		<td width="270">
              			<div style=" margin: 50px">
                        Major
                        </div>
              		</td>
              		<td width="244">
              			<div style=" margin: 50px;">
                         <?php
						if(isset($_SESSION['major'])){
					
							echo "<input name='major' type='text' size='50px' value='". $_SESSION['major'] . "'/>";
						}
						else{
							echo "<input name='major' type='text' size='50px' />";	
						}
						?>
              			</div>
                    </td>
              </tr>
            	
            	<tr>
            		<td width="270">
              			<div style=" margin: 50px">Graduation year
                        </div>
              		</td>
              		<td width="244">
              			<div style=" margin: 50px;">
                        <?php
						if(isset($_SESSION['gradyear'])){
					
							echo "<input name='gradyear' type='text' size='50px' value='". $_SESSION['gradyear'] . "'/>";
						}
						else{
							echo "<input name='gradyear' type='text' size='50px' />";	
						}
						?>
              			</div>
                    </td>
              </tr>
              <tr>
              		<td>
              			<div style=" margin: 50px">
                        Grade Point Average (GPA)
                        </div>
                    </td>
              		<td>
              			<div style=" margin: 50px">
					    <?php
						if(isset($_SESSION['gpa'])){
					
							echo "<input name='gpa' type='text' size='50px' value='". $_SESSION['gpa'] . "'/>";
						}
						else{
							echo "<input name='gpa' type='text' size='50px' />";	
						}
						?>
              			</div>
             		 </td>
              </tr>
              <tr>
            		<td width="270">
              			<div style=" margin: 50px">                        Is this course required for the major indicated?
                        </div>
              		</td>
              		<td width="244" align="center">
              			<div style=" margin: 50px;">
                        <select name="mandatory">

            <option value="required">Yes</option>
        	<option value="notrequired" selected="selected">No</option>
        </select>
              			</div>
                    </td>
              </tr>
               <tr>
            		<td width="270">
              			<div style=" margin: 50px">                        Are you retaking this class?
                        </div>
              		</td>
              		<td width="244" align="center">
              			<div style=" margin: 50px;">
              			  <select name="onemoretime">
              			    <option value="retaking">Yes</option>
              			    <option value="notretaking" selected="selected">No</option>
           			      </select>
              			</div>
                    </td>
              </tr>
              <tr>
              	<td>
                <div style="margin:25px">
                	If you would like to elaborate on why it is necessary for you to take this class, please do so here. This can include why you want to take this class even if it is not required for your major.
              </div>
              </td>
              <td>
              <div style="margin:50px">
              	<input type="text" name="studcomments" size="50px" height="70px"/>
                </div>
                </td>
              </tr>
              <tr>
              		<td width="270">
             		</td>
              		<td align="center" width="244">
              		<input type="submit" name="registration1" value="Next page"/>
              		</td>
                    <td width="166">
                    </td>
              </tr>
          </table>
          </form>

</div>     
    </div>
</body>
</html>