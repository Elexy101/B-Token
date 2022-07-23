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
						<img src="vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome Back <small><?php echo $fetch_user['user'] ?></small> <div class="weight-600 font-30 text-blue">Send Your BT$</div>
						</h4>
						<strong><p class="font-18 max-width-600"><ul><li><strong>>></strong>Send some BT$ token to your friends</li><li><strong>>></strong>Please confirm username before sent, payment is irreversible.</li><li><strong>>></strong>You cannot send token to yourself.</li><li><strong>>></strong>charges applied at 1% for every transaction.</li></ul></p></strong>
					</div>
				</div>
			</div>

			<div class="title pb-20">
				<h2 class="h3 mb-0">My Balance</h2>
			</div>

			<div class="row pb-10">
						
				<div class="col-xl-6 col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark">$<?php echo $fetch_user['token'] ?> <small>BT$</small></div>
								<strong><div class="font-14 text-secondary weight-500 text-right"><?php echo $fetch_query_crypto['symb'] ?> &#149; <?php echo "$".$fetch_query_crypto['price'] ?></div></strong>
								<form method="post">
								<!-- send to user -->
								<input type="text" class="form-control" name="user" placeholder="USERNAME"/><br />
								
								<!-- specify amount sent to user -->
								<input type="text" class="form-control" name="sell" placeholder="SELL AMOUNT"/>
							</div>
							<div class="widget-icon">
								<button name="bts_send"><div class="icon" data-color="#00eccf"><i class="fa fa-money text-danger"></i></div></button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>


		<!--
		=============================================================
		====================== SENT TRANSACTIONS ====================
		=============================================================
		-->
			<div class="card-box pb-10">
				<div class="h5 pd-20 mb-0">Sent Transaction(s)</div>
				<table class="data-table table nowrap">
					<thead>
						<tr>
							<th class="table-plus">Name</th>
							<th>Amount(BT$)</th>
							<th>Tx Id</th>
							<th>Date</th>
							<th class="datatable-nosort">Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php while($row = mysql_fetch_array($query_sent_tx)){ ?>
						<tr>
							<td class="table-plus">
								<div class="name-avatar d-flex align-items-center">
									<div class="avatar mr-2 flex-shrink-0">
										<img src="./anon/anon2.jpeg" class="border-radius-100 shadow" width="40" height="40" alt="">
									</div>
									<div class="txt">
										<div class="weight-600"><?php echo $row['receiver'] ?></div>
									</div>
								</div>
							</td>
							<td><?php echo $row['amt'] ?></td>
							<td><?php echo $row['tx_id'] ?></td>
							<td><?php echo timeAgo($row['date']) ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7">Sent</span></td>
						</tr>
					<?php } ?>					
					</tbody>
				</table>
			</div>
			
			<hr>
		<!--
		=============================================================
		==================== RECEIVED TRANSACTIONS ==================
		=============================================================
		-->
			<div class="card-box pb-10">
				<div class="h5 pd-20 mb-0">Received Transaction(s)</div>
				<table class="data-table table nowrap">
					<thead>
						<tr>
							<th class="table-plus">Name</th>
							<th>Amount(BT$)</th>
							<th>Tx Id</th>
							<th>Date</th>
							<th class="datatable-nosort">Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php while($row = mysql_fetch_array($query_receive_tx)){ ?>
						<tr>
							<td class="table-plus">
								<div class="name-avatar d-flex align-items-center">
									<div class="avatar mr-2 flex-shrink-0">
										<img src="./anon/anon2.jpeg" class="border-radius-100 shadow" width="40" height="40" alt="">
									</div>
									<div class="txt">
										<div class="weight-600"><?php echo $row['sender'] ?></div>
									</div>
								</div>
							</td>
							<td><?php echo $row['amt'] ?></td>
							<td><?php echo $row['tx_id'] ?></td>
							<td><?php echo timeAgo($row['date']) ?></td>
							<td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7">received</span></td>
						</tr>
					<?php } ?>					
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