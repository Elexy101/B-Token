<?php
//include db
include 'db.php';

//GET CRYPTOCURRENCY
$get_crypto = $_GET['coin'];

//PHP CODE  => SUPPLY CRYPTO AMT
$crypto = "SELECT * FROM cryptocurrency WHERE symb = '$get_crypto'";
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
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome To <div class="weight-600 font-30 text-blue">Banking: Lending/Borrowing/Witdrawing (<?php echo $_SERVER['PHP_SELF'] ?></div>
						</h4>
						<b><p class="font-18 max-width-600"><ul><li><strong>>></strong>Lending : Deposit your BT$ token in the bank (1% interest accrue above $1M BT$ counts every single day)</li><li><strong><br />>></strong>Borrowing: The privilege to borrow depends on your lending power. deposit 100k BT$ and rights to borrow begins. 100k BT$ borrows accrue at 1k BT$, the more you deposit, the higher the borrowing and payback interest... </li><li><strong><br />>></strong>Withdrawing: Rights to withdraw is allowed at user's amount</li></ul></p></b>
					</div>
				</div>
			</div>

			<div class="title pb-20">
				<h2 class="h3 mb-0">BTS BANK</h2>
				<br>
				<b>All Deposits: $<?php echo $fetch_query_fetch_sum_all['deposit'] ?></b><br>
				<b>All Withdrawals: $<?php echo $fetch_query_fetch_sum_all_with['withdraw'] ?></b>
			</div>
	<?php echo $error ?>
			<div class="row pb-10">
				<div class="col-xl-6 col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark">DEPOSIT/LENDING</div>
								<strong><div class="font-14 text-secondary weight-500">My Deposit: $<?php echo $fetch_fetch_bank['deposit'] ?></div></strong>
								<form method="post">
								<input type="number" name="dep" class="form-control" placeholder="DEPOSIT AMT" required/>
								
							</div>
							<div class="widget-icon">
								<button name="bank_dep" ><div class="icon" data-color="#00eccf"><i class="fa fa-money text-success"></i></div></button>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				
				<div class="col-xl-6 col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark">WITHDRAW</div>
					<strong><div class="font-14 text-secondary weight-500">My Withdraw: $<?php echo $fetch_withdraw_bank['withdraw'] ?></div></strong>
				
								<form method="post">
								<input type="number" class="form-control" name="with" placeholder="WITHDRAW AMT" required />
							</div>
							<div class="widget-icon">
								<button name="bank_with"><div class="icon" data-color="#00eccf"><i class="fa fa-money text-danger"></i></div></button>
							</div>
							</form>
						</div>
					</div>
				</div>		
			</div>
			
					<CENTER>
				<div class="col-xl-6 col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark">BORROWING (1.5% <sup><i class="icon-copy fa fa-arrow-circle-up" aria-hidden="true"></i></sup>)</div>
								<strong><div class="font-14 text-secondary weight-500">$</div></strong>
								<form method="post">
								<input type="text" class="form-control" name="borr" placeholder="BORROW AMT (coming soon)" disabled/>
							</div>
							<div class="widget-icon">
								<button name="bank_borr"><div class="icon" data-color="#00eccf"><i class="fa fa-money text-danger"></i></div></button>
							</div>
							</form>
						</div>
					</div>
				</div>
				</CENTER>
				

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