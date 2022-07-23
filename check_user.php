<?php
//check if user exists
$sql = "SELECT * FROM user WHERE user = '$user'";
$query_sql = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($query_sql) > 0){
	$error = "<center><font color='red'>Sorry, username already taken...</font></center>";
}
?>