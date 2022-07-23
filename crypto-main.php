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
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome To <div class="weight-600 font-30 text-blue">Cryptocurrency(<?php echo rand(15000, 50000) ?></div>
						</h4>
						<p class="font-18 max-width-600"><ul><li><strong>>></strong>Invest in Cryptocurrency : BTC, ETH, TRX, SHIB, BT$</li><li><strong>>></strong>Invest in something you can afford to lose </li><li><strong>>></strong>Dont risk investing all your BT$ into only one asset. Price can <b>FLUCTUATE</b></li></ul></p>
					</div>
				</div>
			</div>

			<div class="title pb-20">
				<h2 class="h3 mb-0">CRYPTO Tokens Overview...</h2>
			</div>

			<div class="row pb-10">
			<?php
			while($row = mysql_fetch_array($query_crypto)){
			?>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo $row['supply'] ?></div>
								<strong><div class="font-14 text-secondary weight-500"><?php echo $row['symb'] ?> &#149; <?php echo "$".$row['price'] ?></div></strong>
							</div>
							<div class="widget-icon">
								<a href="trade.php?coin=<?php echo $row['symb'] ?>"><div class="icon" data-color="#00eccf"><i class="fa fa-money text-success"></i></div></a>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
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