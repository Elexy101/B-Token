	<div class="left-side-bar">
		<div>
			<a href="#">
				<img src="./anon/anon1.jpeg" style="height: 7em; width: 100%" alt="">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li>
						<a href="crypto-main.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
					</li>
					
					<!-- USER BALANCE -->
						<li>
						<a href="#" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user"></span><span class="mtext">BAL: $<?php echo $fetch_user['token'] ?></span>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-money-1"></span><span class="mtext">Finances</span>
						</a>
						<ul class="submenu">
							<li><a href="crypto-main.php">Cryptocurrency</a></li>
							<li><a href="real-main.php">NFT <small>(coming soon)</small></a></li>
						</ul>
					</li>
					
						<li>
						<a href="send_receive.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-refresh"></span><span class="mtext">Send/Receive</span>
						</a>
					</li>
					
						<li>
						<a href="#" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-building"></span><span class="mtext">BANK <small>(coming soon)</small></span>
						</a>
					</li>
					<!-- THIS IS FOR ADMIN -->
					<?php if($fetch_user['user'] == "Elexy101"){ ?>
						<li>
						<a href="calendar.html" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user"></span><span class="mtext">ADMIN</span>
						</a>
					</li>
					<?php } ?>
					<li>
						<a href="logout.php?logout=<?php echo $fetch_user['user'] ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-building"></span><span class="mtext">Logout</span>
						</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>