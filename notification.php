<?php
//include db
include 'db.php';

//PHP CODE  => SUPPLY CRYPTO AMT
$crypto = "SELECT * FROM cryptocurrency";
$query_crypto = mysql_query($crypto) or die(mysql_error());
//update notification when seen
$cookie = $_COOKIE['user'];
$select_notify = mysql_query("SELECT * FROM notify WHERE notify_user = '$cookie' AND seen = 'no'") or die(mysql_error());
while($row = mysql_fetch_array($select_notify)){
$seen_notify = mysql_query("UPDATE notify SET seen = 'yes' WHERE notify_user = '$row[notify_user]'") or die(mysql_error());
}
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
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<h4>Notifications</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Noifications</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="container pd-0">
				<?php if(mysql_num_rows($notifications) > 0){ ?>
					<div class="timeline mb-30">
						<ul>
						<?php while($row = mysql_fetch_array($notifications)){ 
						//getting auth code from request tb
						$get_request_auth = mysql_query("SELECT * FROM request WHERE user_target = '$fetch_user[user]' AND active = 'no' AND winner = ''") or die(mysql_error());
						$fetch_request_auth = mysql_fetch_array($get_request_auth);
						?>
							<li>
								<div class="timeline-date">
									<?php echo $row['date'] ?>
								</div>
								<div class="timeline-desc card-box">
									<div class="pd-20">
										<h4 class="mb-10 h4"><?php echo $row['title'] ?></h4>
										<p><?php if($row['title'] == "game request"){ echo $row['msg']." <a href='generate_request.php?auth=".$fetch_request_auth['auth']."'>Click here</a> to activate"; }
										else if($row['title'] == "game won"){
										echo $row['msg']." <a href='monitor_request.php'>Click here</a> to view";	
										}else if($row['title'] == "BTS Deposit"){
										echo $row['msg'];
										}
										 ?></p>
									</div>
								</div>
							</li>
						<?php } ?>
						</ul>
					</div>
					<?php }else{ ?>
						<div class="timeline mb-30">
						<ul>
							<li>
								<div class="timeline-date">
									<?php echo $date ?>
								</div>
								<div class="timeline-desc card-box">
									<div class="pd-20">
										<h4 class="mb-10 h4">BTS Notification</h4>
										<p>You do not have any current notification!</p>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<?php } ?>
					
				</div>
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