<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>BT$ ~ Business Token Society </title>

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
	<link rel="stylesheet" type="text/css" href="src/plugins/cropperjs/dist/cropper.css">
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
								<h4>Profile</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<?php echo $error ?>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">
							<div class="profile-photo">
								<a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
								<img src="./anon/anon2.jpeg" alt="" class="avatar-photo">
								<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-body pd-5">
												<div class="img-container">
													<img id="image" src="vendors/images/photo2.jpg" alt="Picture">
												</div>
											</div>
											<div class="modal-footer">
												<input type="submit" value="Update" class="btn btn-primary">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<h5 class="text-center h5 mb-0"><strong>!<?php echo $fetch_user['user'] ?></strong></h5>
							<p class="text-center text-muted font-14">I am Anonymous, catch me if you can!</p>
<!--							<div class="profile-info" hidden="true">
								<h5 class="mb-20 h5 text-blue">Contact Information</h5>
								<ul>
									<li>
										<span>Email Address:</span>
										FerdinandMChilds@test.com
									</li>
									<li>
										<span>Phone Number:</span>
										619-229-0054
									</li>
									<li>
										<span>Country:</span>
										America
									</li>
									<li>
										<span>Address:</span>
										1807 Holden Street<br>
										San Diego, CA 92115
									</li>
								</ul>
							</div>
							<div class="profile-social" hidden="true">
								<h5 class="mb-20 h5 text-blue">Social Links</h5>
								<ul class="clearfix">
									<li><a href="#" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-instagram"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-dribbble"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#3d464d" data-color="#ffffff"><i class="fa fa-dropbox"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#db4437" data-color="#ffffff"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#bd081c" data-color="#ffffff"><i class="fa fa-pinterest-p"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#00aff0" data-color="#ffffff"><i class="fa fa-skype"></i></a></li>
									<li><a href="#" class="btn" data-bgcolor="#00b489" data-color="#ffffff"><i class="fa fa-vine"></i></a></li>
								</ul>
							</div>-->
							<div class="profile-skills">
								<h5 class="mb-20 h5 text-blue">Game Asset(s)</h5>
								<h6 class="mb-5 font-14">BT$ <strong>(<?php echo floor($whale_coin_bts) ?>%)</strong></h6>
								<div class="progress mb-20" style="height: 6px;">
								<?php
									echo '<div class="progress-bar" role="progressbar" style="width: '.$whale_coin_bts.'%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'; ?>
								</div>
								<h6 class="mb-5 font-14">BTC <strong>(<?php echo floor($whale_coin_btc) ?>%)</strong></h6>
								<div class="progress mb-20" style="height: 6px;">
							<?php
									echo '<div class="progress-bar" role="progressbar" style="width: '.$whale_coin_btc.'%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'; ?>
								</div>
								<h6 class="mb-5 font-14">ETH <strong>(<?php echo floor($whale_coin_eth) ?>%)</strong></h6>
								<div class="progress mb-20" style="height: 6px;">
								<?php
									echo '<div class="progress-bar" role="progressbar" style="width: '.$whale_coin_eth.'%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'; ?>
								</div>
								<h6 class="mb-5 font-14">SOL<strong><small>(coming soon...)</small></strong></h6>
								<div class="progress mb-20" style="height: 6px;">
									<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
						<div class="card-box height-100-p overflow-hidden">
							<div class="profile-tab height-100-p">
								<div class="tab height-100-p">
									<ul class="nav nav-tabs customtab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Timeline</a>
										</li>
										<?php if($_COOKIE['user'] == "Elexy101"){ ?>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tasks" role="tab">Tasks</a>
										</li>
										<?php } ?>
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#setting" role="tab">Settings</a>
										</li>
									</ul>
									<div class="tab-content">
										<!-- Timeline Tab start -->
										<div class="tab-pane fade show active" id="timeline" role="tabpanel">
											<div class="pd-20">
												<div class="profile-timeline">
													<div class="timeline-month">
														<h5>Jul, 2022</h5>
													</div>
													<div class="profile-timeline-list">
														<ul>
														<?php
														$count = 1;
														$count_query = mysql_num_rows($query_task);
														for($count=1;$count<=$count_query;$count++){
														}
														while($row = mysql_fetch_array($query_task)){	
														//task table
														$task_tb = "SELECT * FROM user_tasks WHERE user = '$fetch_user[user]' AND task_id = '$row[id]'";
														$query_task_tb = mysql_query($task_tb) or die(mysql_error());
														$fetch_query_task_tb = mysql_fetch_array($query_task_tb);
														?>
															<li>
																<div class="date"><?php echo $row['date'] ?></div>
																<div class="task-name"><i class="ion-android-alarm-clock"></i> Task - <?php echo $row['name']; ?> &#149; <a href="profile.php?task_id=<?php echo $row['id'] ?>&choice=yes">Yes</a> | <a href="profile.php?task_id=<?php echo $row['id'] ?>&choice=No">No</a><?php if($row['id'] == $fetch_query_task_tb['task_id']){ echo "(".$fetch_query_task_tb['task_choice'].")"; } ?></div>
																<p><?php echo $row['message'] ?></p>
																<div class="task-time">Reward: <?php echo $row['amt'] ?>BT$</div>
																<div class="task-time"><?php echo $row['time'] ?></div>
															</li>
														<?php
														}
														?>
														</ul>
													</div>
													<div class="timeline-month">
														<h5>Aug, 2022 (<strong><b>coming soon...</b></strong>)</h5>
													</div>
													<div class="profile-timeline-list">
														<ul>
														<li>
																<div class="date">19 Aug</div>
																<div class="task-name"><i class="ion-android-alarm-clock"></i> Task Three(Cook to Earn) <a href="#">&#149; Start Task</a></div>
																<p>Write steps on how to cook Yam and Egg sauce...</p>
																<div class="task-time">Reward: 20000BT$</div>
																<div class="task-time">09:30 am - 9:30 am</div>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<!-- Timeline Tab End -->
										<!-- Tasks Tab start -->
										<div class="tab-pane fade" id="tasks" role="tabpanel">
											<div class="pd-20 profile-task-wrap">
												<div class="container pd-0">
													<!-- Open Task start -->
													<div class="task-title row align-items-center">
														<div class="col-md-8 col-sm-12">
															<h5>Open Tasks (<?php echo mysql_num_rows($query_task) ?> Left)</h5>
														</div>
														<div class="col-md-4 col-sm-12 text-right">
															<a href="task-add" data-toggle="modal" data-target="#task-add" class="bg-light-blue btn text-blue weight-500"><i class="ion-plus-round"></i> Add</a>
														</div>
													</div>
													<div class="profile-task-list pb-30">
														<ul>
														<?php
														while($row = mysql_fetch_array($query_task)){
														?>
															<li>
																<div class="custom-control custom-checkbox mb-5">
																	<input type="checkbox" class="custom-control-input" id="task-1">
																	<label class="custom-control-label" for="task-1"></label>
																</div>
																<div class="task-type"><?php echo $row['name'] ?></div>
																<?php echo $row['message'] ?>
																<div class="task-assign"><?php echo $row['amt'] ?> <div class="due-date">due date <span><?php echo $row['date'] ?></span></div></div>
															</li>
															<?php }
															?>
														</ul>
													</div>
													<!-- Open Task End -->
													<!-- Close Task start -->
													<div class="task-title row align-items-center">
														<div class="col-md-12 col-sm-12">
															<h5>Closed Tasks</h5>
														</div>
													</div>
													<div class="profile-task-list close-tasks">
														<ul>
															<li>
																<div class="custom-control custom-checkbox mb-5">
																	<input type="checkbox" class="custom-control-input" id="task-close-1" checked="" disabled="">
																	<label class="custom-control-label" for="task-close-1"></label>
																</div>
																<div class="task-type">Email</div>
																Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id ea earum.
																<div class="task-assign">Assigned to Ferdinand M. <div class="due-date">due date <span>22 February 2018</span></div></div>
															</li>
															<li>
																<div class="custom-control custom-checkbox mb-5">
																	<input type="checkbox" class="custom-control-input" id="task-close-2" checked="" disabled="">
																	<label class="custom-control-label" for="task-close-2"></label>
																</div>
																<div class="task-type">Email</div>
																Lorem ipsum dolor sit amet.
																<div class="task-assign">Assigned to Ferdinand M. <div class="due-date">due date <span>22 February 2018</span></div></div>
															</li>
															<li>
																<div class="custom-control custom-checkbox mb-5">
																	<input type="checkbox" class="custom-control-input" id="task-close-3" checked="" disabled="">
																	<label class="custom-control-label" for="task-close-3"></label>
																</div>
																<div class="task-type">Email</div>
																Lorem ipsum dolor sit amet, consectetur adipisicing elit.
																<div class="task-assign">Assigned to Ferdinand M. <div class="due-date">due date <span>22 February 2018</span></div></div>
															</li>
															<li>
																<div class="custom-control custom-checkbox mb-5">
																	<input type="checkbox" class="custom-control-input" id="task-close-4" checked="" disabled="">
																	<label class="custom-control-label" for="task-close-4"></label>
																</div>
																<div class="task-type">Email</div>
																Lorem ipsum dolor sit amet. Id ea earum.
																<div class="task-assign">Assigned to Ferdinand M. <div class="due-date">due date <span>22 February 2018</span></div></div>
															</li>
														</ul>
													</div>
													<!-- Close Task start -->
													
													<!--
													-------------------------------------------------------
													------------------- USER MODAL ------------------------
													-------------------------------------------------------
													-->
													<?php include 'user_modal.php'; ?>
												</div>
											</div>
										</div>
										<!-- Tasks Tab End -->
										<!-- Setting Tab start -->
										<div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
											<div class="profile-setting">
												<form>
													<ul class="profile-edit-list row">
														<li class="weight-500 col-md-6">
															<h4 class="text-blue h5 mb-20">Edit Your Personal Setting</h4>
															<div class="form-group">
																<label>Username</label>
																<input class="form-control form-control-lg" value="<?php echo $fetch_user['user'] ?>" type="text" readonly="">
															</div>
															<div class="form-group">
																<label>Password</label>
																<input class="form-control form-control-lg" value="<?php echo $fetch_user['pass'] ?>" type="password">
															</div>
														
														</li>
														<li class="weight-500 col-md-6">
															<h4 class="text-blue h5 mb-20">Edit Social Media links</h4>
															<div class="form-group">
																<label>Facebook URL:</label>
																<input class="form-control form-control-lg" type="text" placeholder="Paste your link here">
															</div>
															<div class="form-group">
																<label>Twitter URL:</label>
																<input class="form-control form-control-lg" type="text" placeholder="Paste your link here">
															</div>
														</li>
														<div class="col-md-12">
														<center><input type="submit" name="settings" class="btn btn-success btn-sm"/></center></div>
													</ul>
												</form>
											</div>
										</div>
										<!-- Setting Tab End -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-wrap pd-20 mb-20 card-box">
				<strong>BitTrade Society - BT$ By <a href="https://github.com/Elexy101" target="_blank">Elexy101</a></strong>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/cropperjs/dist/cropper.js"></script>
	<script>
		window.addEventListener('DOMContentLoaded', function () {
			var image = document.getElementById('image');
			var cropBoxData;
			var canvasData;
			var cropper;

			$('#modal').on('shown.bs.modal', function () {
				cropper = new Cropper(image, {
					autoCropArea: 0.5,
					dragMode: 'move',
					aspectRatio: 3 / 3,
					restore: false,
					guides: false,
					center: false,
					highlight: false,
					cropBoxMovable: false,
					cropBoxResizable: false,
					toggleDragModeOnDblclick: false,
					ready: function () {
						cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
					}
				});
			}).on('hidden.bs.modal', function () {
				cropBoxData = cropper.getCropBoxData();
				canvasData = cropper.getCanvasData();
				cropper.destroy();
			});
		});
	</script>
</body>
</html>