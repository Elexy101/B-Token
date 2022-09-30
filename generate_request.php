<?php
//include db
include 'db.php';

//PHP CODE  => SUPPLY CRYPTO AMT
$crypto = "SELECT * FROM cryptocurrency";
$query_crypto = mysql_query($crypto) or die(mysql_error());

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
		<?php echo $success?>
		
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
				<h2 class="h3 mb-0"><i class="icon-copy fa fa-hourglass-1" aria-hidden="true"></i> Generate Request...</h2>
			</div>

		<?php echo $error ?>
			<?php 
			$monitor_request3 = mysql_query("SELECT * FROM request WHERE (user = '$fetch_user[user]' or user_target = '$fetch_user[user]') AND (active = 'yes')") or die(mysql_error());
			if(mysql_num_rows($monitor_request3) > 0){ ?>
				<center><hr><font color='red'>Sorry, you cant generate another session game challenge. current session still active.  <a href="monitor_request.php">Click here</a></font><hr></center>
			<?php }else{  ?>
						<!-- GENERATE REPORT -->
			<div class="row pb-10">		
				<div class="col-xl-6 col-lg-8 col-md-8 mb-20">
					<div class="card-box height-100-p widget-style3">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<form method="post">
								<!-- send request to user -->
								<input type="text" class="form-control" name="user" placeholder="Enter username"/><br />
								
								<!-- specify request sent to user -->
								<select class="form-control" name="select_task"><option value="First to gain 10% income">First to gain 5% income<option hidden="true" value="First to own 10 units of an estate">First to own 10 units of an estate</select>
								<br>
								<strong>n/b: Detect a >1M BT$ WHALE using developer option <small>(coming soon!!)</small></strong>
							</div>
							<div class="widget-icon">
								<button name="generate_request"><div class="icon" data-color="#00eccf"><i class="icon-copy fa fa-hourglass-1" aria-hidden="true"></i></div></button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<!-- END OF GENERATE REQUEST  -->
			
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