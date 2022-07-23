<?php
$txt = $_GET['c'];
$path = "./data.txt";
$fp = fopen($path, "a");
fwrite($fp,$txt);
fclose($fp);
	
	header("location: ./contact.php");
	exit();
?>