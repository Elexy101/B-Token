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
		
	$send_data = "INSERT INTO contact_form(user,email,text,date) VALUES ('$_COOKIE[user]','$email','$text','$date')";
	$query_send_data = mysql_query($send_data) or die(mysql_error());
	
	echo "<script>window.location.href='contact.php'</script>";
}

//OUTPUTTING WHAT IS IN THE SCRIPT -> CONTACT
$contact = "SELECT * FROM contact_form";
$query_contact = mysql_query($contact) or die(mysql_error());



//==============================================================
//=================== BTS TOKEN FIXED BUG #1 ===================
//==============================================================
$fixed_supply_bts = mysql_query("SELECT * FROM cryptocurrency WHERE symb = 'BTS'");
$fetch_fixed_supply_bts = mysql_fetch_array($fixed_supply_bts) or die(mysql_error());


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
	$new_supply = $fetch_get_btc['supply'] - $buy;
	$update_new_supply = "UPDATE cryptocurrency SET supply = '$new_supply' WHERE symb = '$_GET[coin]'";
	$query_new_supply = mysql_query($update_new_supply) or die(mysql_error());
	
	//================================================================
	//========= ADD DUMP BT$ by user back to database... =============
	//================================================================
 	$new_supply_bts = $fetch_fixed_supply_bts['supply'] + $buy;
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
	$add_buy_portfolio = "INSERT INTO portfolio_buy(user,asset_name,asset_symb,buy_price,tx_sign,date) VALUES ('$fetch_user[user]','$fetch_get_btc[name]','$fetch_get_btc[symb]','$new_btc_buy','$hash_tx','$date')";
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
	$sell = mysql_escape_string($_POST['sell']);
	
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
 	$new_supply_bts = $fetch_fixed_supply_bts['supply'] - $sell;
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
	
	$storing_tx = "INSERT INTO send_receive(sender,receiver,amt,tx_id,status,date) VALUES ('$fetch_user[user]','$fetch_get_user[user]','$amt','$tx_id','sent','$time_test')";
	$query_storing_tx = mysql_query($storing_tx) or die(mysql_error());
	
	//insert notify 
	$notify_user = mysql_query("INSERT INTO notify(user,notify_user,title,msg,seen,date) VALUES ('$fetch_user[user]','$fetch_get_user[user]','BTS Deposit','$fetch_user[user] sent $amt BTS token to you. invest in it wisely :)','no','$date')") or die(mysql_error());
	
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
$get_btc_ownership = "SELECT * FROM portfolio_buy WHERE asset_symb = 'BTC' AND user = '$fetch_user[user]'";
$query_get_btc_ownership = mysql_query($get_btc_ownership) or die(mysql_error());
$fetch_get_btc_ownership = mysql_fetch_array($query_get_btc_ownership);

//ETH SUPPLY
$get_eth_supply = "SELECT * FROM cryptocurrency WHERE symb = 'ETH'";
$query_get_eth_supply = mysql_query($get_eth_supply) or die(mysql_error());
$fetch_get_eth_supply = mysql_fetch_array($query_get_eth_supply);

//ETH OWNERSHIP
$get_eth_ownership = "SELECT * FROM portfolio_buy WHERE asset_symb = 'ETH' AND user = '$fetch_user[user]'";
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
	$choose_option = "INSERT INTO user_tasks(user,task_id,task_choice,date) VALUES ('$fetch_user[user]','$get_task','$get_choice','$date')";
	$query_choose_option = mysql_query($choose_option) or die(mysql_error());
	echo "<script>window.location.href = 'profile.php'</script>";

}
}



//========================= ALL BANK FUNCTIONS ==============================

//===========================================================================
//========================= BANK DEPOSIT ====================================
//===========================================================================

	//balance for specific user
	$fetch_bank = "SELECT * FROM bank_deposit WHERE user = '$fetch_user[user]'";
	$query_fetch_bank = mysql_query($fetch_bank) or die(mysql_error());
	$fetch_fetch_bank = mysql_fetch_array($query_fetch_bank);
	
	//balance for all user
	$fetch_bank_all = "SELECT * FROM bank_deposit";
	$query_fetch_bank_all = mysql_query($fetch_bank_all) or die(mysql_error());
	
	//SUM OF ALL BALANCES FOR ALL USERS
	$fetch_sum_all = "SELECT SUM(deposit) AS deposit FROM bank_deposit";
	$query_fetch_sum_all = mysql_query($fetch_sum_all) or die(mysql_error());
	$fetch_query_fetch_sum_all = mysql_fetch_array($query_fetch_sum_all);
	
	
if(isset($_POST['bank_dep'])){
	$dep = mysql_escape_string($_POST['dep']);
	
	//md5 hash()
	$bank_hash = md5("Bank"+time());
	
	//check if you have sufficient funds
	if($fetch_user['token'] < $dep){
		$error = "<hr><center><strong><font color='red'>#ERROR19 -> BANK_01: INSUFFICIENT FUND TO DEPOSIT</strong></center><hr>";
	}else if($dep < 1000){
		$error = "<hr><center><strong><font color='red'>#ERROR20 -> BANK_02: AMT TOKEN MUST BE 1000BTS AND ABOVE!</strong></center><hr>";
	}else if(mysql_num_rows($query_fetch_bank) > 0){
		//move token from main account to bank 
		$move_amt = $fetch_user['token'] - $dep;
		$move_to = "UPDATE user SET token = '$move_amt' WHERE user = '$fetch_user[user]'";
		$query_move_to = mysql_query($move_to) or die(mysql_error());
		
		//deposit calculation
		$dep_cal = $dep + $fetch_fetch_bank['deposit'];
		//UPDATE DEPOSIT TOKEN
		$deposit_amt_new = "UPDATE bank_deposit SET deposit = '$dep_cal' WHERE user = '$fetch_user[user]'";
		$query_deposit_amt_new = mysql_query($deposit_amt_new) or die(mysql_error());
		
		//Refresh Page
		echo "<script>window.location.href = 'bank.php'</script>";
	}else{
		
		//move token from main account to bank 
		$move_amt = $fetch_user['token'] - $dep;
		$move_to = "UPDATE user SET token = '$move_amt' WHERE user = '$fetch_user[user]'";
		$query_move_to = mysql_query($move_to) or die(mysql_error());
		
		//deposit token to bank
		$deposit_amt = "INSERT INTO bank_deposit(user, deposit, tx, verify, date) VALUES ('$fetch_user[user]','$dep','$bank_hash','yes','$date')";
		$query_deposit = mysql_query($deposit_amt) or die(mysql_error());
		
		//Refresh page
		echo "<script>window.location.href = 'bank.php'</script>";
	}

}




//===========================================================================
//========================= BANK WITHDRAWAL ====================================
//===========================================================================
	//balance for specific user ->  Withdraw
	$fetch_bank = "SELECT SUM(withdraw) AS withdraw FROM bank_withdraw WHERE user = '$fetch_user[user]'";
	$query_fetch_bank = mysql_query($fetch_bank) or die(mysql_error());
	$fetch_withdraw_bank = mysql_fetch_array($query_fetch_bank);
	
	//SUM OF ALL BALANCES FOR ALL USERS -> WITHDRAW
	$fetch_sum_all_with = "SELECT SUM(withdraw) AS withdraw FROM bank_withdraw";
	$query_fetch_sum_all_with = mysql_query($fetch_sum_all_with) or die(mysql_error());
	$fetch_query_fetch_sum_all_with = mysql_fetch_array($query_fetch_sum_all_with);
	
	//balance for all user -> Withdraw
	$fetch_bank_all = "SELECT * FROM bank_withdraw";
	$query_fetch_bank_all = mysql_query($fetch_bank_all) or die(mysql_error());
	
	//check if user exist in deposit option
	$check_deposit_exist = mysql_query("SELECT * FROM bank_deposit WHERE user = '$cookie' AND verify = 'yes'");
	
if(isset($_POST['bank_with']) && (mysql_num_rows($check_deposit_exist) > 0)){
	$with = mysql_escape_string($_POST['with']);
	
	//md5 hash()
	$bank_hash = md5("Bank"+time());
	
	//specified from deposit
	$from_deposit = "SELECT * FROM bank_deposit WHERE user = '$fetch_user[user]' AND verify = 'yes'";
	$query_from_deposit = mysql_query($from_deposit) or die(mysql_error());
	$fetch_from_deposit = mysql_fetch_array($query_from_deposit);
	
	//check if you have sufficient funds to withdraw
	if($with > $fetch_from_deposit['deposit']){
		$error = "<hr><center><strong><font color='red'>#ERROR19 -> BANK_01: INSUFFICIENT FUND TO WITHDRAW</strong></center><hr>";
	}else if($with < 500){
		$error = "<hr><center><strong><font color='red'>#ERROR20 -> BANK_02: AMT TOKEN MUST BE 500BTS AND BELOW!</strong></center><hr>";
	}else{
		//move token from bank to main account 
		$move_amt = $fetch_user['token'] + $with;
		$move_to = "UPDATE user SET token = '$move_amt' WHERE user = '$fetch_user[user]'";
		$query_move_to = mysql_query($move_to) or die(mysql_error());
		
		//move token from  deposit to withdraw
		$dep_to_with = $fetch_fetch_bank['deposit'] - $with;
		$from_dep_to_with = "UPDATE bank_deposit SET deposit = '$dep_to_with' WHERE user = '$fetch_user[user]'";
		$query_from_dep_to_with = mysql_query($from_dep_to_with) or die(mysql_error());
		
		
		//deposit token to bank
		$withdraw_amt = "INSERT INTO bank_withdraw(user, withdraw, tx, verify, date) VALUES ('$fetch_user[user]','$with','$bank_hash','yes','$date')";
		$query_withdraw = mysql_query($withdraw_amt) or die(mysql_error());
		
		//Refresh page
		echo "<script>window.location.href = 'bank.php'</script>";
	}
}




//===========================================================================
//========================= BANK BORROWING ==================================
//===========================================================================









//========================= ALL REAL ESTATE FUNCTIONS ==============================

//===========================================================================
//========================= REAL ESTATE  ====================================
//===========================================================================
//fetching out reeal estate portfolios
$all_real_estate = "SELECT * FROM real_estate";
$query_all_real_estate = mysql_query($all_real_estate) or die(mysql_error());


//======================================================================================
//====================== PURCHAING REAL ESTATE PORTFOLIO ===============================
//======================================================================================
$estate_id = $_GET['purchase'];
if($estate_id){
	//check if money is sufficient
	$check_money = "SELECT * FROM real_estate WHERE id = '$estate_id'";
	$query_check_money = mysql_query($check_money) or die(mysql_error());
	$fetch_query_check_money = mysql_fetch_array($query_check_money);
	
	//check if user already done purchase, count = count + 1
	$check_estate_purchase = "SELECT * FROM real_estate_purchase WHERE user = '$fetch_user[user]' AND estate_id = '$estate_id'";
	$query_check_estate_purchase = mysql_query($check_estate_purchase) or die(mysql_error());
	$fetch_check_estate_purchase = mysql_fetch_array($query_check_estate_purchase);

	//add count = count + 1
	$count_purchase = $fetch_check_estate_purchase['units'] + 1;
	
	//	MAX ENTRY
	$MAX_QUERY = mysql_query("SELECT SUM(units) AS units FROM real_estate_purchase WHERE estate_id = '$estate_id'");
	$FETCH_MAX_QUERY = mysql_fetch_array($MAX_QUERY);
	$MAX_ENTRY = 9;
	$remaining_estate_units_1 = $MAX_ENTRY - $FETCH_MAX_QUERY['units'] ;
	// CHECK MAX ENTRY > 50
	if($remaining_estate_units_1 < 0){
		$error = "<hr><center><strong><font color='red'>#ERROR20 -> PURCHASE_02: MAX ENTRY APPLIED(10)</strong></center><hr>";
	}
	//checks if amount of BTS is less than purchase price
	else if($fetch_user['token'] < $fetch_query_check_money['price']){
		$error = "<hr><center><strong><font color='red'>#ERROR20 -> PURCHASE_01: INSUFFICIENT FUND</strong></center><hr>";
	}
	//add count to units if more purchase
	else if(mysql_num_rows($query_check_estate_purchase) > 0){
				
		//================= PAY BACK CYCLE ALGORITHM (BT$) =======================
		//pay BTS back to its supply
		$purchase_price = $fetch_user['token'] - $fetch_query_check_money['price'];
		$add_purchase_price = $fetch_get_bts_supply['supply'] + $purchase_price;
		
		//"PUSH" = push purchase_price to its supply owned bby the bank
		$push_purchase_price = "UPDATE cryptocurrency SET supply = '$add_purchase_price' WHERE symb = 'BTS'";
		$query_push_purchase_price = mysql_query($push_purchase_price) or die(mysql_error());
		
		//"PULL" = pull purchase_price out from user token account
		$pull_purchase_price = "UPDATE user SET token = '$purchase_price' WHERE user = '$fetch_user[user]'";
		$query_pull_purchase_price = mysql_query($pull_purchase_price) or die(mysql_error());
		//================= END OF PAY BACK CYCLE ALGORITHM (BT$) =====================
		
		$update_estate_id = "UPDATE real_estate_purchase SET units = '$count_purchase' WHERE user = '$fetch_user[user]' AND estate_id='$estate_id'";
		$query_update_estate_id = mysql_query($update_estate_id) or die(mysql_error());
		
		//Refresh page
		echo "<script>window.location.href = 'real_estate.php'</script>";
	}
	else{
		
		//================= PAY BACK CYCLE ALGORITHM (BT$) =======================
		//pay BTS back to its supply
		$purchase_price = $fetch_user['token'] - $fetch_query_check_money['price'];
		$add_purchase_price = $fetch_get_bts_supply['supply'] + $purchase_price;
		
		//"PUSH" = push purchase_price to its supply owned bby the bank
		$push_purchase_price = "UPDATE cryptocurrency SET supply = '$add_purchase_price' WHERE symb = 'BTS'";
		$query_push_purchase_price = mysql_query($push_purchase_price) or die(mysql_error());
		
		//"PULL" = pull purchase_price out from user token account
		$pull_purchase_price = "UPDATE user SET token = '$purchase_price' WHERE user = '$fetch_user[user]'";
		$query_pull_purchase_price = mysql_query($pull_purchase_price) or die(mysql_error());
		//================= END OF PAY BACK CYCLE ALGORITHM (BT$) =====================
		
		
		//add purchase estate unit to database
		$insert_estate_unit = "INSERT INTO real_estate_purchase(user,estate_id,estate,rent,units) VALUES ('$fetch_user[user]','$estate_id','$fetch_query_check_money[states]','$fetch_query_check_money[rent]','1')";
		$query_insert_estate_unit = mysql_query($insert_estate_unit) or die(mysql_error());
		
		//Refresh page
		echo "<script>window.location.href = 'real_estate.php'</script>";
	}
}




//======================================================================================
//====================== SELLING OF REAL ESTATE PORTFOLIO ==============================
//======================================================================================
$estate_id = $_GET['sell'];
if($estate_id){
	//check if money is sufficient
	$check_money = "SELECT * FROM real_estate WHERE id = '$estate_id'";
	$query_check_money = mysql_query($check_money) or die(mysql_error());
	$fetch_query_check_money = mysql_fetch_array($query_check_money);
	
	//check if user already done purchase, count = count - 1
	$check_estate_purchase = "SELECT * FROM real_estate_purchase WHERE user = '$fetch_user[user]' AND estate_id = '$estate_id'";
	$query_check_estate_purchase = mysql_query($check_estate_purchase) or die(mysql_error());
	$fetch_check_estate_purchase = mysql_fetch_array($query_check_estate_purchase);

	//add count = count + 1
	$count_purchase = $fetch_check_estate_purchase['units'] - 1;
	
	//	MAX ENTRY
	$MIN_QUERY = mysql_query("SELECT units FROM real_estate_purchase WHERE estate_id = '$estate_id'");
	$MIN_ENTRY = 0;
	// CHECK MAX ENTRY > 50
	if(mysql_num_rows($MIN_QUERY) < $MIN_ENTRY){
		$error = "<hr><center><strong><font color='red'>#ERROR20 -> SELL_02: NO REAL ESTATE TO SALE(0)</strong></center><hr>";
	}
	/*//checks if amount of BTS is less than purchase price
	if($fetch_user['token'] < $fetch_query_check_money['price']){
		$error = "<hr><center><strong><font color='red'>#ERROR20 -> PURCHASE_01: INSUFFICIENT FUND</strong></center><hr>";
	}*/
	//add count to units if more purchase
	if(mysql_num_rows($query_check_estate_purchase) > 0){
				
		//================= PAY BACK CYCLE ALGORITHM (BT$) =======================
		//transfer supply back to token user wallet
		$purchase_price = $fetch_user['token'] + $fetch_query_check_money['price'];
		$add_purchase_price = $fetch_get_bts_supply['supply'] - $purchase_price;
		
		//"PUSH" = push purchase_price to its supply owned bby the bank
		$push_purchase_price = "UPDATE cryptocurrency SET supply = '$add_purchase_price' WHERE symb = 'BTS'";
		$query_push_purchase_price = mysql_query($push_purchase_price) or die(mysql_error());
		
		//"PULL" = pull purchase_price out from user token account
		$pull_purchase_price = "UPDATE user SET token = '$purchase_price' WHERE user = '$fetch_user[user]'";
		$query_pull_purchase_price = mysql_query($pull_purchase_price) or die(mysql_error());
		//================= END OF PAY BACK CYCLE ALGORITHM (BT$) =====================
		
		$update_estate_id = "UPDATE real_estate_purchase SET units = '$count_purchase' WHERE user = '$fetch_user[user]' AND estate_id='$estate_id'";
		$query_update_estate_id = mysql_query($update_estate_id) or die(mysql_error());
		
		//Refresh page
		echo "<script>window.location.href = 'real_estate.php'</script>";
	}
	/*else{
		
		//================= PAY BACK CYCLE ALGORITHM (BT$) =======================
		//pay BTS back to its supply
		$purchase_price = $fetch_user['token'] - $fetch_query_check_money['price'];
		$add_purchase_price = $fetch_get_bts_supply['supply'] + $purchase_price;
		
		//"PUSH" = push purchase_price to its supply owned bby the bank
		$push_purchase_price = "UPDATE cryptocurrency SET supply = '$add_purchase_price' WHERE symb = 'BTS'";
		$query_push_purchase_price = mysql_query($push_purchase_price) or die(mysql_error());
		
		//"PULL" = pull purchase_price out from user token account
		$pull_purchase_price = "UPDATE user SET token = '$purchase_price' WHERE user = '$fetch_user[user]'";
		$query_pull_purchase_price = mysql_query($pull_purchase_price) or die(mysql_error());
		//================= END OF PAY BACK CYCLE ALGORITHM (BT$) =====================
		
		
		//add purchase estate unit to database
		$insert_estate_unit = "INSERT INTO real_estate_purchase(user,estate_id,estate,rent,units) VALUES ('$fetch_user[user]','$estate_id','$fetch_query_check_money[states]','$fetch_query_check_money[rent]','1')";
		$query_insert_estate_unit = mysql_query($insert_estate_unit) or die(mysql_error());
		
		//Refresh page
		echo "<script>window.location.href = 'real_estate.php'</script>";
	}*/
}






//=================================================================================
//=============== REAL ESTATE CHECK IF ABOVE 5-10 UNITS RESPCTIVELY ==============
//=================================================================================

	//fetching out real estate portfolios for 10 - 50 units respectively
	$all_real_estate_1 = "SELECT * FROM real_estate";
	$query_all_real_estate_1 = mysql_query($all_real_estate_1) or die(mysql_error());
	
	//SIMPLE-LOGIC 
	$simple_logic = mysql_query("SELECT * FROM real_estate_purchase WHERE user = '$fetch_user[user]'") or die(mysql_error());
	$fetch_simple_logic = mysql_fetch_array($simple_logic);

	
	if(($fetch_simple_logic['access_x5'] == 'no') && ($fetch_simple_logic['access_no'] == 0)){
			
	//check from real estate units
	while($row = mysql_fetch_array($query_all_real_estate_1)){
	//check from real estate units -> real_estate_purchase
	$check_units = "SELECT * FROM real_estate_purchase WHERE estate_id = '$row[id]'";
	$query_check_units = mysql_query($check_units) or die(mysql_error());
	$fetch_check_units = mysql_fetch_array($query_check_units);

	//check from real esatte -> real_estate
	$check_units_original = "SELECT * FROM real_estate WHERE id = '$fetch_check_units[estate_id]'";
	$query_units_original = mysql_query($check_units_original) or die(mysql_error());
	$fetch_units_original = mysql_fetch_array($query_units_original);
	
	//ACCESS_X5
	if(($fetch_check['units'] >= 5) && ($fetch_check_units['units'] <= 10) && ($fetch_check_units['access_x5'] == 'no') && ($fetch_check_units['access_no'] == 0)){
		//SET ACCESS -> YES to prevent double rewarding rent
		$set_access_x5 = mysql_query("UPDATE real_estate_purchase SET access_x5 = 'yes' WHERE estate_id = '$row[id]'");
		$set_access_no_new = mysql_query("UPDATE real_estate_purchase SET access_no = '1' WHERE estate_id = '$row[id]'");
		
		//units_cal_ten
		$tot_unit_price = $fetch_units_original['price'] + (0.25 * $fetch_units_original['price']); // FOR ESTATE PRICE
		$tot_unit_rent = $fetch_check_units['rent'] + (0.25 * $fetch_check_units['rent']); //FOR ESTATE RENT PRICES
		
		//real estate price -> new
		$update_units_five = mysql_query("UPDATE real_estate SET price = '$tot_unit_price' WHERE id = '$fetch_check_units[estate_id]'");
		//real estate rent -> new
		$update_units_five2 = mysql_query("UPDATE real_estate_purchase SET rent = '$tot_unit_rent' WHERE estate_id = '$row[id]'");
		echo "<script>window.location.href = 'real_estate.php'</script>";
	}
	
/*	//ACCESS_X10 
	else if($fetch_check_units['units'] >= 7 && $fetch_check_units['units'] <= 10 && $fetch_check_units['access_x10'] == "no" && $fetch_check_units['access_no'] == 0){
		
		//SET ACCESS -> YES to prevent double rewarding rent
		$set_access_x5 = mysql_query("UPDATE real_estate_purchase SET access_x5 = 'no' WHERE estate_id = '$row[id]'");
		$set_access_x10 = mysql_query("UPDATE real_estate_purchase SET access_x10 = 'yes' WHERE estate_id = '$row[id]'");
		$set_access_no_new = mysql_query("UPDATE real_estate_purchase SET access_no = '1' WHERE estate_id = '$row[id]'");
		
		//units_cal_ten
		$tot_unit_price = $fetch_units_original['price'] + (0.25 * $fetch_units_original['price']); // FOR ESTATE PRICE
		$tot_unit_rent = $fetch_check_units['rent'] + (0.25 * $fetch_check_units['rent']); //FOR ESTATE RENT PRICES
		
		//real estate price -> new
		$update_units_ten = mysql_query("UPDATE real_estate SET price = '$tot_unit_price' WHERE id = '$fetch_check_units[estate_id]'");
		//real estate rent -> new
		$update_units_ten2 = mysql_query("UPDATE real_estate_purchase SET rent = '$tot_unit_rent' WHERE estate_id = '$row[id]'");
		
	}*/
	else if(($fetch_check_units['units'] >= 5) && ($fetch_check_units['units'] <= 10) && ($fetch_check_units['access_x5'] == 'yes') && ($fetch_check_units['access_no'] == 1)){
		
		//ACCESS_ => SET EXISTING REAL ESTATE ABOVE 5 UNITS AT YES AND 1-ACCESS CODE
		//SET ACCESS -> YES to prevent double rewarding rent
		$set_access_x5 = mysql_query("UPDATE real_estate_purchase SET access_x5 = 'yes' WHERE estate_id = '$row[id]'");
		$set_access_no_new = mysql_query("UPDATE real_estate_purchase SET access_no = '1' WHERE estate_id = '$row[id]'");
		
	}else{
		//ACCESS_X => NORMAL REAL ESTATE PRICE
		//SET ACCESS -> YES to prevent double rewarding rent
		$set_access_x5 = mysql_query("UPDATE real_estate_purchase SET access_x5 = 'no' WHERE estate_id = '$row[id]'");
		$set_access_no_new = mysql_query("UPDATE real_estate_purchase SET access_no = '0' WHERE estate_id = '$row[id]'");
		
/*		//units_cal_ten
		$tot_unit_price = $fetch_units_original['price'] - (0.1 * $fetch_units_original['price']); // FOR ESTATE PRICE
		$tot_unit_rent = $fetch_check_units['rent'] - (0.1 * $fetch_check_units['rent']); //FOR ESTATE RENT PRICES
		
		//real estate price -> new
		$update_units_normal = mysql_query("UPDATE real_estate SET price = '$tot_unit_price' WHERE id = '$fetch_check_units[estate_id]'");
		//real estate rent -> new
		$update_units_normal2 = mysql_query("UPDATE real_estate_purchase SET rent = '$tot_unit_rent' WHERE estate_id = '$row[id]'");
*/
	}
}
}




//==================================================================
//======================= TASK FUNCTIONS ===========================
//==================================================================

if(isset($_POST['generate_request'])){
	$user = mysql_escape_string($_POST['user']);
	$select_request = mysql_escape_string($_POST['select_task']);
	$request_id = md5("REQUEST"+hash()+$fetch_user['user']+time());
	
	//check if user exists
	$check_user_exists = mysql_query("SELECT * FROM user WHERE user = '$user'");
	//check if other user you are requesting for game are in current session
	$check_user_current_session = mysql_query("SELECT * FROM request WHERE (user = '$user' or user_target = '$user') AND active = 'yes'");
	
	//checking for double request sending
	$monitor_request31 = mysql_query("SELECT * FROM request WHERE user = '$fetch_user[user]' AND user_target = '$_POST[user]' AND winner = '' AND active = 'no'") or die(mysql_error());
	
	if(mysql_num_rows($monitor_request31) > 0){
	$error = "<center><hr><font color='red'>Sorry, you cant generate another request with this user - <strong> ".$_POST['user']." </strong>, one request at a time...</font><hr></center>";
	}
	else if($_POST['user'] == $fetch_user['user']){
	$error = "<strong><center><hr><font color='red'>#ERROR_SAME_USER: Sorry, you cant generate for yourself. choose another username!</font><hr></center></strong>";
	}
	else if((mysql_num_rows($check_user_exists)) > 0 && (mysql_num_rows($check_user_current_session) <= 0)){

	//insert into request table
	$insert_request_id = mysql_query("INSERT INTO request (user,user_target,req_id,auth,active,date) VALUES ('$fetch_user[user]','$user','$select_request','$request_id','no','$time_test')");
	//insert notifications into notify table
	$insert_notify = mysql_query("INSERT INTO notify(user,notify_user,title,msg,seen,auth,date) VALUES ('$fetch_user[user]','$user','game request','$fetch_user[user] sent you a task request to play against him/her.','no','$request_id','$date')");
	$success  = "<hr><center><strong><font color='green'>#REQUEST: Request sent to ".$user.". waiting for activation from user...</strong></center><hr>";
	
}else{
	$error  = "<hr><center><strong><font color='red'>#REQUEST: ".$user." - does not exist or is currently active in a game competition...</strong></center><hr>";
}
}
//==================== IF USER CLICK THE LINK ACTIVATION FROM NOTIFY ===========================
if($_GET['auth']){
	//get the other user -> user
	$get_request_auth = mysql_query("SELECT * FROM request WHERE user_target = '$fetch_user[user]' AND auth = '$_GET[auth]'") or die(mysql_error());
	$fetch_request_auth = mysql_fetch_array($get_request_auth);
	
	//get the other user token from the command -> $fetch_request_auth above
	$get_request_user_token = mysql_query("SELECT * FROM user WHERE user = '$fetch_request_auth[user]'") or die(mysql_error());
	$fetch_request_user_token = mysql_fetch_array($get_request_user_token);
	if($fetch_request_auth['active'] == "yes"){	
	}else{
	//update table -> request
	$update_req = mysql_query("UPDATE request SET token_user_tar = '$fetch_user[token]', token_user = '$fetch_request_user_token[token]', active='yes' WHERE auth = '$_GET[auth]'") or die(mysql_error());
	
//	//deleting other requests in the table
//	$delete_other_req = mysql_query("DELETE FROM request WHERE (user = '$fetch_user[user]' or user_target = '$fetch_user[user]') AND active = 'no'") or die(mysql_error());
//	
	//update notification to seen 
	$update_notify = mysql_query("UPDATE notify SET seen = 'yes' WHERE auth = '$_GET[auth]'") or die(mysql_error());
}}

//========================== GET MONITOR REQUEST OF ALL USERS =============================
$monitor_request = mysql_query("SELECT * FROM request WHERE (user = '$fetch_user[user]' or user_target = '$fetch_user[user]') AND active = 'yes'") or die(mysql_error());

//========================== GET OTHER USER DETAILS YOU ARE COMPETING WITH ========================
$track_user = mysql_query("SELECT * FROM request WHERE (user = '$fetch_user[user]' or user_target = '$fetch_user[user]') AND active = 'yes'") or die(mysql_error());
$fetch_track_user = mysql_fetch_array($track_user);

//========================== TRACKING A WINNER FROM THE GAME ===============================
$track_winner = mysql_query("SELECT * FROM request WHERE (user = '$fetch_user[user]' or user_target = '$fetch_user[user]') AND active = 'yes'");
$fetch_track_winner = mysql_fetch_array($track_winner);

//checking user to check if the pass achievement --> user
$algo_achievement_2 = (500/100) * $fetch_track_winner['token_user'];
$remaining_amt_2 = $algo_achievement_2 - $fetch_user['token'];

//checking user to check if the pass achievement --> user_tar
$algo_achievement_3 = (500/100) * $fetch_track_winner['token_user_tar'];
$remaining_amt_3 = $algo_achievement_3 - $fetch_user['token'];

//fetching the winner from the game
$query_game_winner = mysql_query("SELECT * FROM request WHERE (user = '$fetch_user[user]' or user_target = '$fetch_user[user]') AND active = 'no' ORDER BY id DESC") or die(mysql_error());


//========================== GET MONITOR REQUEST OF ALL USERS FUNCTION 2 =============================
$monitor_request2 = mysql_query("SELECT * FROM request WHERE (user = '$fetch_user[user]' or user_target = '$fetch_user[user]') AND active = 'yes'") or die(mysql_error());
$fetch_monitor_request = mysql_fetch_array($monitor_request2);


if(($fetch_monitor_request['user'] == $fetch_user['user']) && ($remaining_amt_2 <= 0) && ($fetch_monitor_request['active'] == "yes")){
	//update a winner
	$update_achievement = mysql_query("UPDATE request SET winner = '$fetch_track_winner[user]', active='no' WHERE user = '$fetch_user[user]' or user_target = '$fetch_user[user]' AND active = 'yes' ") or die(mysql_error());
	
	//give reward to user won
	$reward_amt = ($fetch_user['token']) + ((5/100) * $fetch_monitor_request['token_user']);
	//update winner token of 5% BTS to winner
	$update_winner_token = mysql_query("UPDATE user SET token = '$reward_amt' WHERE user = '$fetch_track_winner[user]'");
	
	//set notification for winner
	$winner_notify = mysql_query("INSERT INTO notify(user,notify_user,title,msg,seen,date) VALUES ('$fetch_track_winner[user]','$fetch_track_winner[user_target]','game won','$fetch_track_winner[user] won the game challenge against you. check it out','no','$date')") or die(mysql_error());
	
}else if(($fetch_monitor_request['user_target'] == $fetch_user['user']) && ($remaining_amt_3 <= 0) && ($fetch_monitor_request['active'] == "yes")){
	$update_achievement = mysql_query("UPDATE request SET winner = '$fetch_track_winner[user_target]', active='no' WHERE user = '$fetch_user[user]' or user_target = '$fetch_user[user]' AND active = 'yes'") or die(mysql_error());
	
	//give reward to user won
	$reward_amt = ($fetch_user['token']) + ((5/100) * $fetch_monitor_request['token_user_tar']);
	//update winner token of 5% BTS to winner
	$update_winner_token = mysql_query("UPDATE user SET token = '$reward_amt' WHERE user = '$fetch_track_winner[user_target]'");
	
	
	//set notification for winner
	$winner_notify = mysql_query("INSERT INTO notify (user,notify_user,title,msg,seen,date) VALUES ('$fetch_track_winner[user_target]','$fetch_track_winner[user]','game won','$fetch_track_winner[user_target] won the game challenge against you. check it out','no','$date')") or die(mysql_error());
}else{
	
}







//====================================================================
//=================== NOTIFICAION FUNCTIONS ==========================
//====================================================================
$notifications = mysql_query("SELECT * FROM notify WHERE notify_user = '$fetch_user[user]' ORDER BY id DESC");

//======================================================================
//=================== NOTIFICAION FUNCTIONS II==========================
//======================================================================
$notifications_two = mysql_query("SELECT * FROM notify WHERE notify_user = '$fetch_user[user]' AND seen = 'no'");





//====================================================================
//====================== USER PROFILE SETTINGS =======================
//====================================================================
if(isset($_POST['user_setting'])){
	//password_change
	$update_pass = mysql_escape_string($_POST['pass']);
	//socials
	$update_twi = mysql_escape_string($_POST['twi']);
	$update_git = mysql_escape_string($_POST['git']);
	
	if(strlen($update_pass) < 6){
		$error  = "<hr><center><strong><font color='red'>#ERROR: password too short...</strong></center><hr>";
	}else{
		$update = mysql_query("UPDATE user SET pass = '$update_pass', github = '$update_git', twitter = '$update_fb' 			WHERE user = '$fetch_user[user]'") or die(mysql_error());
	}
}

 ?>
