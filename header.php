	<?php 
	//ADMIN FUNCTION TO EXECUTE PRICE EFFECT
	include 'admin_func.php';
	
	//users functions
	include 'functions.php';
	
	//Time function
	include 'time.php';
	 ?>
	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search">
				<form>
					<div class="form-group mb-0">
						<i class="dw dw-search2 search-icon"></i>
						<input type="text" class="form-control search-input" placeholder="Search Here">
						<div class="dropdown">
							<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
								<i class="ion-arrow-down-c"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">From</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">To</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">Subject</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="text-right">
									<button class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="header-right">
		
		<!-- IF THE ADMIN CLICKS THE BUTTON, ALL ASSET PRICES ARE AFFECTED -->
		<form method="get">
		<div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" name="clik" href="trade.php?clik=<?php echo "Elexy101" ?>" data-toggle="right-sidebar">
						<i class="dw dw-refresh"></i>
					</a>
				</div>
			</div>
		</form>
			
			<div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
						<i class="dw dw-settings2"></i>
					</a>
				</div>
			</div>
			<div class="user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
						<i class="icon-copy dw dw-notification"></i>
						<span class="badge notification-active"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="notification-list mx-h-350 customscroll">
							<ul>
							<?php 
							while($notify1 = mysql_fetch_array($query_notify)){
							?>
								<li>
									<a href="#">
										<img src="vendors/images/img.jpg" alt="">
										<h3><?php echo $notify1['receiver'] ?></h3>
										<p>sent you <?php echo $notify1['amt'] ?> BT$ <i class="pull-right"><?php echo timeAgo($notify1['date']) ?></i></p>
									</a>
								</li>
							<?php
}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="./anon/anon2.jpeg" alt="">
						</span>
						<span class="user-name"><?php echo $_COOKIE['user'] ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="profile.php"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="profile.php"><i class="dw dw-settings2"></i> Setting</a>
						<a class="dropdown-item" href="#"><i class="dw dw-help"></i> Help</a>
						<a class="dropdown-item" href="logout.php?logout=<?php echo $fetch_user['user'] ?>"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
			<div class="github-link">
				<a href="https://github.com/Elexy101" target="_blank"><img src="vendors/images/github.svg" alt=""></a>
			</div>
		</div>
	</div>