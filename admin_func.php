<?php
//check if user cookie exist
if($_COOKIE['user']){
}
else{
	echo "<script>window.location.href = 'login.php'</script>";
}
//include db
include 'db.php';
$cookie = $_COOKIE['user'];
$user = "SELECT * FROM user WHERE user = '$cookie'";
$query_user = mysql_query($user) or die(mysql_error());
$fetch_user = mysql_fetch_array($query_user);

//auto-random the page
$page = $_SERVER['PHP_SELF']."?clik=Elexy101";

$sec = rand(50000,1000000);
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

//===========================================================================
//==================== BANK CREDIT INTEREST ABOVE $1M =======================
//===========================================================================
$cookie = $_COOKIE['user'];
$deposit_user = "SELECT * FROM bank_deposit WHERE user = '$cookie'";
$query_deposit_user = mysql_query($deposit_user) or die(mysql_error());
$fetch_deposit_user = mysql_fetch_array($query_deposit_user);

if($fetch_deposit_user['deposit'] >= 1000000){
	//Add some credits up
	$add_credit_calc = (1/100) * $fetch_deposit_user['deposit'];
	
	//update token in main user account balance 
	$add_credit = $fetch_deposit_user['deposit'] + $add_credit_calc;
	$update_add_credit_main = "UPDATE bank_deposit SET deposit = '$add_credit' WHERE user = '$cookie'";
	$query_update_add_credit_main = mysql_query($update_add_credit_main) or die(mysql_error());
}


//=============================================================================
//=========================  REAL ESTATE RENT COUNTS ==========================
//=============================================================================
$real_estate_purchase_reload = "SELECT * FROM real_estate_purchase WHERE user = '$cookie'";
$query_real_estate_purchase_reloaded = mysql_query($real_estate_purchase_reload) or die(mysql_error());
$fetch_real_estate_purchase_reloaded = mysql_fetch_array($query_real_estate_purchase_reloaded);

$real_estate_purchase_reload3 = mysql_query("SELECT * FROM real_estate_purchase WHERE user = '$cookie'")or die(mysql_error());


	if(mysql_num_rows($real_estate_purchase_reload3) > 0){
	//fetching user 
while($row3 = mysql_fetch_array($real_estate_purchase_reload3)){

//adding unit rental increment
$unit_rental_increment = "SELECT SUM(rent*units) AS rent_all FROM real_estate_purchase WHERE estate_id = '$row3[estate_id]'";
$query_unit_rental_increment = mysql_query($unit_rental_increment) or die(mysql_error());
$fetch_unit_rental_increment = mysql_fetch_array($query_unit_rental_increment);

//check if user purchase estate
	$rent_count = $fetch_unit_rental_increment['rent_all'];
	$add_rent_price = ($rent_count) + $fetch_user['token'];
	$query_add_rent_price = mysql_query("UPDATE user SET token = '$add_rent_price' WHERE user = '$row3[user]'") or die(mysql_error());
	}
}


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