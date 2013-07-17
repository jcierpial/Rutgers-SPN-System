<?php
$link = mysql_connect("localhost", "csuser", "csf2f534") or die("Unable to connect to MySQL");
mysql_select_db("project", $link) or die("Could not select database");
?>