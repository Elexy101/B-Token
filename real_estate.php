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
							Welcome To Our<div class="weight-600 font-30 text-blue">Real Estate </div>
						</h4>
						<b><p class="font-18 max-width-600"><ul><li><strong>>></strong>Purchase : You can buy unit of properties here via BT$ Token. The more a user buyer buy units on a single state, the price increases and vice versa.</li><li><strong><br />>></strong>Rent: You can make your rent counts for you while you sleep. Its a passive income.</li><li><strong><br />>></strong>Sale: Rights to sale a unit is possible. sell higher, earn more.<b>N/B: All sales are distributed to the bank holdings</b></li></ul></p></b>
					</div>
				</div>
			</div>

	<?php echo $error ?>
	
	<div class="tab">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active text-blue" data-toggle="tab" href="#purchase" role="tab" aria-selected="true">Estate Assets</a>
									</li>
								</ul>
		<div class="tab-content">
									<div class="tab-pane fade show active" id="purchase" role="tabpanel">					
				<div class="contact-directory-list">
						<ul class="row">
						<?php while($row = mysql_fetch_array($query_all_real_estate)){ 
							
						//FIND OUT REMAINING UNITS FOR EACH ESTATE
						$estate_remanining_units = mysql_query("SELECT SUM(units) AS units FROM real_estate_purchase WHERE estate_id = '$row[id]'");
						$tot_estate_units = 10;
						$fetch_estate_remaining_units = mysql_fetch_array($estate_remanining_units);
						$remaining_estate_units = $tot_estate_units - $fetch_estate_remaining_units['units'];
						?>
							<li class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
								<div class="contact-directory-box">
									<div class="contact-dire-info text-center">
										<div class="contact-avatar">
											<span>
												<img src="./real_estate/<?php echo $row['img'] ?>" alt="">
											</span>
										</div>
										<div class="contact-name">
											<h4><?php echo $row['states'] ?></h4>
											<B><small>(<?php echo $remaining_estate_units ?> remaining units)</small></B>
											<p>Owned By Bank BT$</p>
											<strong><div class="work text-success"><i class="fa fa-money"></i> $<?php echo $row['price'] ?>  / Rent: $<?php echo $row['rent'] ?></div></strong>
										</div>
										<!--<div class="contact-skill">
											<span class="badge badge-pill">UI</span>
											<span class="badge badge-pill">UX</span>
											<span class="badge badge-pill">Photoshop</span>
											<span class="badge badge-pill badge-primary">+ 8</span>
										</div>-->
										<?php 	
										//check if money is sufficient
										$check_money_user = "SELECT * FROM real_estate";
										$query_check_money_user = mysql_query($check_money_user) or die(mysql_error());
										$fetch_query_check_money_user = mysql_fetch_array($query_check_money_user);									
										//count no. of purchases acquired by the user
										$check_estate_purchase_user = "SELECT * FROM real_estate_purchase WHERE user = '$fetch_user[user]' AND estate_id = '$row[id]'";
										$query_check_estate_purchase_user = mysql_query($check_estate_purchase_user) or die(mysql_error());
										$fetch_check_estate_purchase_user = mysql_fetch_array($query_check_estate_purchase_user);
										?>
										<div class="profile-sort-desc">
											<?php if(mysql_num_rows($query_check_estate_purchase_user) > 0){ ?><strong>Unit owned: <?php echo $fetch_check_estate_purchase_user['units'] ?> &#149; <a href="real_estate.php?sell=<?php echo $row['id'] ?>" style="color: red"><strong>sell</strong></a><?php }else{echo "<strong>Unit owned: NULL</strong>";} ?></strong><br>
											<strong>Rent reward: <?php echo $fetch_check_estate_purchase_user['rent'] * $fetch_check_estate_purchase_user['units'] ?></strong>
										</div>
									</div>
									<div class="view-contact">
										<a href="real_estate.php?purchase=<?php echo $row['id'] ?>">PURCHASE UNIT</a>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				</div>
				
				<!-- SALE OF REAL ESTATE UNIT -->
						<div class="tab-content">
									<div class="tab-pane fade" id="sale" role="tabpanel">					
				<div class="contact-directory-list">
						<ul class="row">
						<?php while($row = mysql_fetch_array($query_all_real_estate)){ ?>
							<li class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
								<div class="contact-directory-box">
									<div class="contact-dire-info text-center">
										<div class="contact-avatar">
											<span>
												<img src="./real_estate/<?php echo $row['img'] ?>" alt="">
											</span>
										</div>
										<div class="contact-name">
											<h4><?php echo $row['states'] ?></h4>
											<p>Owned By Bank BT$</p>
											<strong><div class="work text-success"><i class="fa fa-money"></i> $<?php echo $row['price'] ?>  / Rent: $<?php echo $row['rent'] ?></div></strong>
										</div>
										<!--<div class="contact-skill">
											<span class="badge badge-pill">UI</span>
											<span class="badge badge-pill">UX</span>
											<span class="badge badge-pill">Photoshop</span>
											<span class="badge badge-pill badge-primary">+ 8</span>
										</div>-->
										<div class="profile-sort-desc">
											<strong>Unit owned: </strong><br>
											<strong>Rent reward: <?php ?></strong>
										</div>
									</div>
									<div class="view-contact">
										<a href="#">SALE UNIT</a>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
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