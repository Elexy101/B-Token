<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

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
			

				<!-- horizontal Basic Forms Start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Contact Form #1</h4>
							<p class="mb-30">We will send a response to you via <strong>Email</strong>, please stay active within the next 12hrs to receive email response. Thank You!</p>
							<br>
							<?php while($row = mysql_fetch_array($query_contact)){ ?>
							TEST XSS
							USERNAME: <?php echo $row['user'] ?>
							EMAIL: <?php echo $row['email'] ?>
							MSG: <?php echo $row['text'] ?>
							<?php } ?>
						</div>
					</div>
					<form method="post">
						<div class="form-group">
							<label>Username</label>
							<input class="form-control" name="user" type="text" value="<?php echo $_COOKIE['user'] ?>" disabled="true">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" name="email" placeholder="user@example.com" type="email">
						</div>
						
	<div class="form-group">
		<label>Textarea</label>
		<textarea class="form-control" name="text" placeholder="send a message..."></textarea>
		<br>
		<div class="pull-right">
	<input type="submit" name="contact_form" class="btn btn-success" value="Submit">
</div>
	</div>
</form>

						</div>
					</div>
				</div>
				<!-- horizontal Basic Forms End -->


			</div>
		<div class="footer-wrap pd-20 mb-20 card-box">
				BT$ TOKEN - PROJECT <strong>BY</strong> <a href="https://github.com/Elexy101" target="_blank">Emmanuel Elexy</a>

	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>