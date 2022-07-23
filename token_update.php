<?php
//add contract token to user and minus it from exisiting user
$symb = "BTS";
$sql = "SELECT * FROM cryptocurrency WHERE symb = '$symb'";
$query_sql = mysql_query($sql) or die(mysql_error());
$fetch_query_sql = mysql_fetch_array($query_sql);

$token = 100000;

//overall token left -> remaining...
$overall_token = $fetch_query_sql['supply'] - $token;

//update token in the database...
$token_update = "UPDATE cryptocurrency SET supply = '$overall_token' WHERE symb = '$symb'";
$query_token_update = mysql_query($token_update) or die(mysql_error());

//END
?>