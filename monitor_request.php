<?php
//include db
include 'db.php';

//GET CRYPTOCURRENCY
$get_crypto = $_GET['coin'];

//PHP CODE  => SUPPLY CRYPTO AMT
$crypto = "SELECT * FROM cryptocurrency WHERE symb = 'BTS'";
$query_crypto = mysql_query($crypto) or die(mysql_error());
$fetch_query_crypto = mysql_fetch_array($query_crypto);
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>BT$ - Business Token</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body>


<!-- HEADER -->
<?php include 'header.php'; ?>
<!-- RIGHT SIDEBAR -->
<?php include 'right_sidebar.php'; ?>
<!-- LEFT SIDEBAR -->
<?php include 'left_sidebar.php' ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="xs-pd-20-10 pd-ltr-20">
		<!-- ERROR MODE -->
		<?php echo $error ?>
		
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="vendors/images/product-img4.jpg" style="border-radius: 2em" alt="">
					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome To <div class="weight-600 font-30 text-blue"><i class="icon-copy fa fa-hourglass-half" aria-hidden="true"></i> Goal Request</div>
						</h4>
						<p class="font-18 max-width-600"><ul><li><strong>>></strong> Generate a goal and send to a friend to compete</li><li><strong>>></strong> All your session request are saved in "My Request" </li><li><strong>>></strong> Every request from both side play-users demands <strong>5% tax and 10-15%</strong> gain returns</b></li></ul></p>
					</div>
				</div>
			</div>


			<div class="title pb-20">
				<h2 class="h3 mb-0">My Balance</h2>
			</div>


		<!--
		=============================================================
		====================== MY GAME REQUEST  ====================
		=============================================================
		-->
			<div class="card-box pb-10">
				<div class="h5 pd-20 mb-0">My game monitor<SMALL><strong>(Bal: BT$ <?php echo $fetch_user['token'] ?>)</strong></SMALL></div>
				<table class="data-table table nowrap">
					<thead>
						<tr>
							<th>Booked Amt</th>
							<th>Expected Amt</th>
							<th>Remain. Amt</th>
							<th class="datatable-nosort">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php while($row = mysql_fetch_array($monitor_request)){						
					//========================== ALGORITHM FOR 10% ACHIEVEMENT ================================
					//check if $row['token_user'] -> user
					if($row['user'] == $fetch_user['user']){
					$algo_achievement = (500/100) * $row['token_user'];
					$remaining_amt = $algo_achievement - $fetch_user['token'];
					 ?>
						<tr>
							<td><?php echo $row['token_user'] ?></td>
							<td><?php echo $algo_achievement ?></td>
							<td><?php echo $remaining_amt ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($row['date']) ?></span></td>
						</tr>
					<?php }else{ ?>
					<tr>
					<?php 					
					$algo_achievement_1 = (500/100) * $row['token_user_tar'];
					$remaining_amt_1 = $algo_achievement_1 - $fetch_user['token']; 
					?>
							<td><?php echo $row['token_user_tar'] ?></td>
							<td><?php echo $algo_achievement_1 ?></td>
							<td><?php echo $remaining_amt_1 ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($row['date']) ?></span></td>
						</tr>
					<?php }} ?>					
					</tbody>
				</table>
			</div>
			
			<hr>
		<!--
		=============================================================
		==================== OTHER USER GAME REQUEST =================
		=============================================================
		-->
			<div class="card-box pb-10">
				<div class="h5 pd-20 mb-0"><?php if(($fetch_track_user['user'] == $fetch_user['user'])){ echo $fetch_track_user['user_target']. "'s Monitor "; 
				}else if(($fetch_track_user['user_target'] == $fetch_user['user'])){
				echo $fetch_track_user['user']. "'s Monitor ";
				}else{}
				
				?></div>
				<table class="data-table table nowrap">
					<thead>
						<tr>
							<th>Booked Amt</th>
							<th>Expected Amt</th>
							<th>Remain. Amt</th>
							<th class="datatable-nosort">Action</th>
						</tr>
					</thead>
					<tbody>

						<tr>
					<?php 	
					if(($fetch_track_user['user'] == $fetch_user['user'])){	
					//get other user real time token
					$get_real_user_token = mysql_query("SELECT * FROM user WHERE user = '$fetch_track_user[user_target]'");			
					$fetch_real_user_token = mysql_fetch_array($get_real_user_token);
					
					$algo_achievement_4 = (500/100) * $fetch_track_user['token_user_tar'];
					$remaining_amt_4 = $algo_achievement_4 - $fetch_real_user_token['token']; 
					?>
					<td><?php echo $fetch_track_user['token_user_tar'] ?></td>
					<td><?php echo $algo_achievement_4 ?></td>
					<td><?php echo $remaining_amt_4 ?></td>
					<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($fetch_track_user['date']) ?></span></td>
					<?php
					if($remaining_amt_4 <= 0){
						$update_achievement = mysql_query("UPDATE request SET winner = '$fetch_track_user[user]', active='no' WHERE user = '$fetch_user[user]' or user_target = '$fetch_user[user]' AND active = 'yes' ") or die(mysql_error());
					}
					?>
					<?php
	}else if(($fetch_track_user['user_target'] == $fetch_user['user'])){
					//get other user real time token
					$get_real_user_token = mysql_query("SELECT * FROM user WHERE user = '$fetch_track_user[user]'");			
					$fetch_real_user_token = mysql_fetch_array($get_real_user_token);
					
					$algo_achievement_4 = (500/100) * $fetch_track_user['token_user'];
					$remaining_amt_4 = $algo_achievement_4 - $fetch_real_user_token['token']; 
					?>
					<td><?php echo $fetch_track_user['token_user'] ?></td>
					<td><?php echo $algo_achievement_4 ?></td>
					<td><?php echo $remaining_amt_4 ?></td>
					<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($fetch_track_user['date']) ?></span></td>
				
					<?php
}else{}
					?>
						</tr>
										
					</tbody>
				</table>
			</div>
			
			
			<hr>
			<!--
			=========================================================================
			=========================== MY LOG ACTIVITIES ===========================
			--> 
			
			<div class="card-box pb-10">
				<div class="h5 pd-20 mb-0">
				My Log(s)
				</div>
				<table class="data-table table nowrap">
					<thead>
						<tr>
							<th>MAIN USER</th>
							<th>COMPETING USER</th>
							<th class="datatable-nosort">Date</th>
							<th class="datatable-nosort">Action</th>
						</tr>
					</thead>
					<tbody>
				<?php while($row = mysql_fetch_array($query_game_winner)){						
					//========================== ALGORITHM FOR 10% ACHIEVEMENT ================================
					//check if $row['token_user'] -> user
					if($row['user'] == $fetch_user['user'] && $row['winner'] == $fetch_user['user']){
				?>
						<tr>
							<td><?php echo $row['user'] ?></td>
							<td><?php echo $row['user_target'] ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($row['date']) ?></span></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7">winner</span></td>
						</tr>
					<?php }else if($row['user'] == $fetch_user['user'] && $row['winner'] != $fetch_user['user']){ ?>
						<tr>
							<td><?php echo $row['user'] ?></td>
							<td><?php echo $row['user_target'] ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($row['date']) ?></span></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7">loser</span></td>
						</tr>
					<?php }else if($row['user_target'] == $fetch_user['user'] && $row['winner'] == $fetch_user['user']){ ?>
						<tr>
							<td><?php echo $row['user_target'] ?></td>
							<td><?php echo $row['user'] ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($row['date']) ?></span></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7">winner</span></td>
						</tr>
					<?php }else{ ?>
						<tr>
							<td><?php echo $row['user_target'] ?></td>
							<td><?php echo $row['user'] ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo timeAgo($row['date']) ?></span></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7">loser</span></td>
						</tr>
					<?php }} ?>					
					</tbody>			
				</table>
			</div>
			
			

		<!-- 
		===========================================
		================ FOOTER ===================
		===========================================
		-->
		<?php include 'footer.php'; ?>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/jQuery-Knob-master/jquery.knob.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script src="vendors/scripts/dashboard3.js"></script>
	<script src="vendors/scripts/dashboard2.js"></script>
</body>
</html>