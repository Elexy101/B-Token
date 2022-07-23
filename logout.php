<?php
include 'db.php';
//DESTROY COOKIE -> redirect to login.php

if(isset($_GET['logout'])){
	$user = "SELECT * FROM user WHERE user = '$_GET[logout]'";
	$query_user = mysql_query($user) or die(mysql_error());
	
    if(mysql_num_rows($query_user) > 0){
    	$cookie_name = "user";
		$cookie_value = $fetch_user['user'];
		setcookie($cookie_name, $cookie_value, time() - (86400 * 30), "/"); // 86400 = 1 day
        echo "<script>window.location='login.php'</script>";
    }
    else{
        $error = "<script>alert('Error #20: Logout failed...')</script>";
    }
}
?>