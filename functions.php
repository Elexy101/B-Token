<?php
if(!$_COOKIE['user']){
	header("location: ./login.php");
}
//include db
include 'db.php';
$cookie = $_COOKIE['user'];
$user = "SELECT * FROM user WHERE user = '$cookie'";
$query_user = mysql_query($user) or die(mysql_error());
$fetch_user = mysql_fetch_array($query_user);

//date()
$date = @date("Y-m-d");
//test_time
$time_test = time();

//CONTACT FORM SENT TO DATABASE
if(isset($_POST['contact_form'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$text = $_POST['text'];
		
	$send_data = "INSERT INTO contact_form(id,user,email,text,date) VALUES ('id','$_COOKIE[user]','$email','$text','$date')";
	$query_send_data = mysql_query($send_data) or die(mysql_error());
	
	echo "<script>window.location.href='contact.php'</script>";
}

//OUTPUTTING WHAT IS IN THE SCRIPT -> CONTACT
$contact = "SELECT * FROM contact_form";
$query_contact = mysql_query($contact) or die(mysql_error());


//==============================================
//=============== BUY COIN TOKEN ================
//==============================================
if(isset($_POST['buy_token'])){
		
	//dump back BT$ to get BTC
	$buy = $_POST['buy'];
	
	//test if $buy > default value or <
	if($buy <= $fetch_user['token']){

	//========================================================
	//================= check -> eligible ====================
	//========================================================
	$get_btc = "SELECT * FROM cryptocurrency WHERE symb = '$_GET[coin]'";
	$query_get_btc = mysql_query($get_btc) or die(mysql_error());
	$fetch_get_btc = mysql_fetch_array($query_get_btc);
	
	//============= NEW COIN PRICE PURCHASE ==================
	$new_btc_buy =  $buy / $fetch_get_btc['price'] ; //SET NEW BTC PURCHASE...
	
	//===============================================================
	//=============== UPDATE user default token -> BT$ ==============
	//===============================================================
    $default_token = $fetch_user['token'] - $buy;
	$update_default_token = "UPDATE user SET token = '$default_token' WHERE user = '$fetch_user[user]'";
	$query_update_default_token = mysql_query($update_default_token) or die(mysql_error());
	
	//===============================================================
	//========= update supply token in -> cryptocurrency ============
	//=============================================================== 
	$new_supply = $fetch_get_btc['supply'] - $new_btc_buy;
	$update_new_supply = "UPDATE cryptocurrency SET supply = '$new_supply' WHERE symb = '$_GET[coin]'";
	$query_new_supply = mysql_query($update_new_supply) or die(mysql_error());
	
	//================================================================
	//========= ADD DUMP BT$ by user back to database... =============
	//================================================================
 	$new_supply_bts = $fetch_get_btc['supply'] + $buy;
	$update_new_supply_bts = "UPDATE cryptocurrency SET supply = '$new_supply_bts' WHERE symb = 'BTS'";
	$query_new_supply_bts = mysql_query($update_new_supply_bts) or die(mysql_error());
	
	
	//hash tx for verification...
	$hash_tx = md5("bittech"+time()*3600);
	
	//==================================================================
	//=================== CHECK  ========================
	//==================================================================
	$select_buy_portfolio = "SELECT * FROM portfolio_buy WHERE user = '$fetch_user[user]' AND asset_symb = '$_GET[coin]'";
	$query_select_buy_portfolio = mysql_query($select_buy_portfolio) or die(mysql_error());
	$fetch_select_buy_portfolio = mysql_fetch_array($query_select_buy_portfolio);
	
	
	//===================================================================
	//================== UPDATE COIN TOKEN PORTFOLIO ====================
	//===================================================================
	$update_buy_price = $fetch_select_buy_portfolio['buy_price'] + $new_btc_buy;
	$update_buy_portfolio = "UPDATE portfolio_buy SET buy_price = '$update_buy_price', date = '$date' WHERE user = '$fetch_user[user]' AND asset_symb = '$_GET[coin]'";
	$query_update_portfolio = mysql_query($update_buy_portfolio) or die(mysql_error());
	
	//checking if user hadnt made payment before, continue...
	if(mysql_num_rows($query_select_buy_portfolio) <= 0){
	//Adding new btc token to database for portfolio
	$add_buy_portfolio = "INSERT INTO portfolio_buy(id,user,asset_name,asset_symb,buy_price,tx_sign,date) VALUES ('id','$fetch_user[user]','$fetch_get_btc[name]','$fetch_get_btc[symb]','$new_btc_buy','$hash_tx','$date')";
	//query token -> buy porfolio
	$query_add_buy_portfolio = mysql_query($add_buy_portfolio) or die(mysql_error());
		}
		echo "<script>window.location.href='trade.php?coin=".$_GET['coin']."'</script>";
	//UPDATING...
}else{
	$error = "<script>alert('Insufficient Funds...')</script>";
	echo $error;
}
}




	//=========================================================
	//=============== VIEW BALANCE OF COIN ====================
	//=========================================================
	$view_coin = "SELECT buy_price FROM portfolio_buy WHERE user = '$fetch_user[user]' AND asset_symb = '$_GET[coin]'";
	$query_view_coin = mysql_query($view_coin) or die(mysql_error());
	$fetch_query_view_coin = mysql_fetch_array($query_view_coin);



	//==============================================
	//=============== SELL COIN TOKEN ================
	//==============================================
	if(isset($_POST['sell_token'])){
		
	//dump back $coin to get $BTS
	$sell = $_POST['sell'];
	
	//test if $sell < default value or <
	$total_dollar_coin = $fetch_query_view_coin['buy_price'] * $fetch_query_crypto['price'];
	if($sell <= $total_dollar_coin){

	//========================================================
	//================= check -> eligible ====================
	//========================================================
	$get_btc = "SELECT * FROM cryptocurrency WHERE symb = '$_GET[coin]'";
	$query_get_btc = mysql_query($get_btc) or die(mysql_error());
	$fetch_get_btc = mysql_fetch_array($query_get_btc);
	
	//============= NEW COIN PRICE PURCHASE ==================
	$new_btc_sell =  $sell / $fetch_query_crypto['price'] ; //SET NEW BTC SALE...
	
	//===============================================================
	//=============== UPDATE user default token -> BT$ ==============
	//===============================================================
    $default_token = $fetch_user['token'] + $sell;
	$update_default_token = "UPDATE user SET token = '$default_token' WHERE user = '$fetch_user[user]'";
	$query_update_default_token = mysql_query($update_default_token) or die(mysql_error());
	
	//===============================================================
	//========= update supply token in -> cryptocurrency ============
	//=============================================================== 
	$new_supply = $fetch_get_btc['supply'] + $sell;
	$update_new_supply = "UPDATE cryptocurrency SET supply = '$new_supply' WHERE symb = '$_GET[coin]'";
	$query_new_supply = mysql_query($update_new_supply) or die(mysql_error());
	
	//================================================================
	//========= ADD DUMP BT$ by user back to database... =============
	//================================================================
 	$new_supply_bts = $fetch_get_btc['supply'] - $sell;
	$update_new_supply_bts = "UPDATE cryptocurrency SET supply = '$new_supply_bts' WHERE symb = 'BTS'";
	$query_new_supply_bts = mysql_query($update_new_supply_bts) or die(mysql_error());
	
	
	//hash tx for verification...
	$hash_tx = md5("bittech"+time()*3600);
	
	
	//==================================================================
	//=================== CHECK COIN ========================
	//==================================================================
	$select_sell_portfolio = "SELECT * FROM portfolio_buy WHERE user = '$fetch_user[user]' AND asset_symb = '$_GET[coin]'";
	$query_select_sell_portfolio = mysql_query($select_sell_portfolio) or die(mysql_error());
	$fetch_select_sell_portfolio = mysql_fetch_array($query_select_sell_portfolio);
	
	
	//===================================================================
	//================== UPDATE COIN TOKEN PORTFOLIO ====================
	//===================================================================
	$update_sell_price = $fetch_select_sell_portfolio['buy_price'] - $new_btc_sell;
	$update_sell_portfolio = "UPDATE portfolio_buy SET buy_price = '$update_sell_price', date = '$date' WHERE user = '$fetch_user[user]' AND asset_symb = '$_GET[coin]'";
	$query_update_portfolio = mysql_query($update_sell_portfolio) or die(mysql_error());
	
	echo "<script>window.location.href='trade.php?coin=".$_GET['coin']."'</script>";
	//UPDATING...
}else{
	$error = "<script>alert('Insufficient Funds...')</script>";
	echo $error;
}
}







//=========================================================================+
//===================== BT$ SELL TO SPECIFIED USER ========================+
//=========================================================================+
if(isset($_POST['bts_send'])){
	$send_user = mysql_escape_string($_POST['user']);
	$amt = mysql_escape_string($_POST['sell']);
	
	//get specified user details
	$get_user = "SELECT * FROM user WHERE user = '$send_user'";
	$query_get_user = mysql_query($get_user) or die(mysql_error());
	$fetch_get_user = mysql_fetch_array($query_get_user);
	
	//check if specified user exist in database
	if($send_user != $fetch_get_user['user']){
		$error = "<hr><center><strong><font color='red'>#Error14: User does not exist.</strong></center><hr>";
		echo "<script>alert('User does not exist')</script>";
	}
	else if($send_user == $fetch_user['user']){
		$error = "<hr><center><strong><font color='red'>#Error15: Access denied sending token to ".$fetch_user['user']."</strong></center><hr>";
	}
	//if user amount < send amount
	else if($amt > $fetch_user['token']){
		$error = "<hr><center><strong><font color='red'>#Error16: Insufficient fund. Please Fund account!</strong></center><hr>";
	}
	else{
	
	$token_sender_bal = $fetch_user['token'] - $amt;
	
	$token_receiver_bal = $fetch_get_user['token'] + $amt;
	//remove specified amount from sender account
	$remove_bal = "UPDATE user SET token = '$token_sender_bal' WHERE user = '$fetch_user[user]'";
	$query_remove_bal = mysql_query($remove_bal) or die(mysql_query());
	
	
	//add specified amount to receiver account
	$add_bal = "UPDATE user SET token = '$token_receiver_bal' WHERE user = '$fetch_get_user[user]'";
	$query_add_bal = mysql_query($add_bal) or die(mysql_error());
	
	//storing user transaction
	$tx_id = "tx_".rand(100,100000000)+md5(@date("Y-m-d"))+rand(1000,100000000);
	
	$storing_tx = "INSERT INTO send_receive(id,sender,receiver,amt,tx_id,status,date) VALUES ('id','$fetch_user[user]','$fetch_get_user[user]','$amt','$tx_id','sent','$time_test')";
	$query_storing_tx = mysql_query($storing_tx) or die(mysql_error());
	
	//tx sent successfully...
	echo "<script>alert('tx sent successfully...')</script>";
	
	echo "<script>window.location.href='send_receive.php'</script>";
	}
}


//===============================================================================
//======================== FETCH SENT TX FROM TRANSFER ==========================
//===============================================================================
$sent_tx = "SELECT * FROM send_receive WHERE sender = '$fetch_user[user]'";
$query_sent_tx = mysql_query($sent_tx) or die(mysql_error());

//===============================================================================
//====================== FETCH RECEIVED TX FROM TRANSFER ========================
//===============================================================================
$receive_tx = "SELECT * FROM send_receive WHERE receiver = '$fetch_user[user]'";
$query_receive_tx = mysql_query($receive_tx) or die(mysql_error());



//================================================================================
//======================= NOTIFICATION REQUEST TOKEN TX ==========================
//================================================================================
$notify = "SELECT * FROM send_receive WHERE sender = '$fetch_user[user]'";
$query_notify = mysql_query($notify) or die(mysql_error());





//================================================================================
//======================== AM I A WHALE OR NOT ? =================================
//================================================================================
//BTS SUPPLY
$get_bts_supply = "SELECT * FROM cryptocurrency WHERE symb = 'BTS'";
$query_get_bts_supply = mysql_query($get_bts_supply) or die(mysql_error());
$fetch_get_bts_supply = mysql_fetch_array($query_get_bts_supply);

//BTC SUPPLY
$get_btc_supply = "SELECT * FROM cryptocurrency WHERE symb = 'BTC'";
$query_get_btc_supply = mysql_query($get_btc_supply) or die(mysql_error());
$fetch_get_btc_supply = mysql_fetch_array($query_get_btc_supply);

//BTC OWNERSHIP
$get_btc_ownership = "SELECT * FROM portfolio_buy WHERE asset_symb = 'BTC'";
$query_get_btc_ownership = mysql_query($get_btc_ownership) or die(mysql_error());
$fetch_get_btc_ownership = mysql_fetch_array($query_get_btc_ownership);

//ETH SUPPLY
$get_eth_supply = "SELECT * FROM cryptocurrency WHERE symb = 'ETH'";
$query_get_eth_supply = mysql_query($get_eth_supply) or die(mysql_error());
$fetch_get_eth_supply = mysql_fetch_array($query_get_eth_supply);

//ETH OWNERSHIP
$get_eth_ownership = "SELECT * FROM portfolio_buy WHERE asset_symb = 'ETH'";
$query_get_eth_ownership = mysql_query($get_eth_ownership) or die(mysql_error());
$fetch_get_eth_ownership = mysql_fetch_array($query_get_eth_ownership);

//SOL SUPPLY
//====== COMING SOON.... ======

//My total worth -> BTS	
$whale_coin_bts = ($fetch_user['token'] / $fetch_get_bts_supply['supply']) * 100;
//My total worth -> BTC
$whale_coin_btc = (($fetch_get_btc_ownership['buy_price'] *  $fetch_get_btc_supply['price'])/ $fetch_get_bts_supply['supply']) * 100;
//My total worth -> ETH
$whale_coin_eth = (($fetch_get_eth_ownership['buy_price'] * $fetch_get_eth_supply['price'] )/ $fetch_get_bts_supply['supply']) * 100;


//==============================================================
//============== FETCH TASK FROM DATABASE -> USERS ============
//==============================================================
$fetch_task = "SELECT * FROM tasks WHERE status = 'open'";
$query_task = mysql_query($fetch_task) or die(mysql_error());


//================================================================
//==================== CHOOSE YES/NO OPTION ======================
//================================================================
$get_task = $_GET['task_id'];
$get_choice = $_GET['choice'];

if($get_task && $get_choice){
//task table
$task_tb = "SELECT * FROM user_tasks WHERE user = '$fetch_user[user]' AND task_id = '$get_task'";
$query_task_tb = mysql_query($task_tb) or die(mysql_error());

//check if user already in db to prevent double entry into task

if(mysql_num_rows($query_task_tb) > 0){
	$error = "<hr><center><strong><font color='red'>#Error18: Task cant be query twice!</strong></center><hr>";
}else{
	//charge 1000BT$ for every task
	$charge_task = $fetch_user['token'] - 1000;
	$supply_bts  = $fetch_get_bts_supply['supply'] + 1000;
	
	//update user token -> $charge_task
	$update_token = "UPDATE user SET token = '$charge_task' WHERE user = '$fetch_user[user]'";
	$query_update_token = mysql_query($update_token) or die(mysql_error());
	
	//update BT$ supply -> $supply_bts
	$update_token_bts = "UPDATE cryptocurrency SET supply = '$supply_bts' WHERE symb = 'BTS'";
	$query_update_token_bts = mysql_query($update_token_bts) or die(mysql_error());
	
	
	//task table
	$choose_option = "INSERT INTO user_tasks(id,user,task_id,task_choice,date) VALUES ('id','$fetch_user[user]','$get_task','$get_choice','$date')";
	$query_choose_option = mysql_query($choose_option) or die(mysql_error());
	echo "<script>window.location.href = 'profile.php'</script>";

}
}
 ?>