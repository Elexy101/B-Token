<?php
//include db
include 'db.php';

//auto-random the page
$page = $_SERVER['PHP_SELF']."?clik=Elexy101";
$sec = rand(100000,1000000);

echo "<script>window.setInterval('refresh()', $sec); function refresh(){ window.location.href='$page'; }</script>";

//MARKET MANIPULATION
if(isset($_GET['clik'])){
//BTC
$random_btc = rand(14500, 40000);
//SOL 
$random_sol =  rand(34, 89);
//ETH
$random_eth = rand(990,2022);
//BT$ -> STABLE TOKEN (BUT COULD RISE/DUMP DEPENDING ON HOW USERS USE IT, BUT WONT DUMP/RISE MUCH)
$random_bts = null;

//UPDATE BTC PRICE
$update_btc = "UPDATE cryptocurrency SET price = '$random_btc' WHERE symb = 'BTC'";
$query_update_btc = mysql_query($update_btc) or die(mysql_error());

//UPDATE BTC PRICE
$update_sol = "UPDATE cryptocurrency SET price = '$random_sol' WHERE symb = 'SOL'";
$query_update_sol = mysql_query($update_sol) or die(mysql_error());

//UPDATE ETH PRICE
$update_eth = "UPDATE cryptocurrency SET price = '$random_eth' WHERE symb = 'ETH'";
$query_update_eth = mysql_query($update_eth) or die(mysql_error());

echo "<script>window.location.href='crypto-main.php'</script>";

}

//ADD TASK TO DATABASE
if(isset($_POST['admin_task'])){
	$task_name = $_POST['name'];
	$task_reward = $_POST['amt'];
	$task_msg = $_POST['msg'];
	$task_date = substr($_POST['date'],0, 6);
	$task_time = $_POST['time'];
	
	$insert_data = "INSERT INTO tasks(id,name,amt,message,status,time,date) VALUES ('id','$task_name','$task_reward','$task_msg','open','$task_time','$task_date')";
	$query_insert_data = mysql_query($insert_data) or die(mysql_error());	
}

//FETCH TASK FROM DATABASE -> ADMIN
$fetch_task = "SELECT * FROM tasks WHERE status = 'open'";
$query_task = mysql_query($fetch_task) or die(mysql_error());

?>