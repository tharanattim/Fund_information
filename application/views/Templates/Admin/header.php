<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo $title;?></title>
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/images/favicon_io/apple-touch-icon.png')?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/images/favicon_io/favicon-32x32.png')?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/favicon_io/favicon-16x16.png')?>">
	<link rel="manifest" href="<?php echo base_url('assets/images/favicon_io/site.webmanifest')?>"
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/fonts/fontawesome/css/all.css')?>">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap/dist/css/bootstrap.min.css')?>">
	<!-- dataTable CSS -->
	<link rel="stylesheet" href="<?php echo base_url('themes/MDB-Admin/css/addons/datatables.css')?>">
	<!-- Booking CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css')?>">
	<!-- Fonts -->
	<link rel="stylesheet" href="<?php echo base_url('assets/fonts/Kanit/font-kanit.css')?>">
	<!-- Sweet Alert -->
	<link rel="stylesheet" href="<?php echo base_url('node_modules/sweetalert2/dist/sweetalert2.min.css')?>">
	<!-- Dropzone-->
	<link rel="stylesheet" href="<?php echo base_url('node_modules/dropzone-5.7.0/dist/min/dropzone.min.css')?>">
	<!-- Chart-->
	<link rel="stylesheet" href="<?php echo base_url('node_modules/chart.js/dist/Chart.min.css')?>">

</head>
<body class="fixed-sn">
<!-- Main Navigation -->
<header>
	<!-- Sidebar navigation -->
	<div id="slide-out" class="side-nav sn-bg-4 fixed stylish-color-dark">
		<ul class="custom-scrollbar">
			<!-- Logo -->
			<li class="logo-sn waves-effect py-3">
				<div class="text-center">
					<a href="#" class="pl-0"><img src="<?php echo base_url('assets/images/logo_eq.png')?>" width="180px"></a>
				</div>
			</li>
			<hr style="noshade color: white">
			<!-- Side navigation links -->
			<li>
				<ul class="collapsible collapsible-accordion">

					<li>
						<a class="collapsible-header waves-effect arrow-r" href="<?php echo base_url('dashboard');?>">
							<i class="fas fa-home-lg"></i>หน้าแรก
						</a>
					</li>
					<li>
						<a class="collapsible-header waves-effect arrow-r" href="<?php echo base_url('department');?>">
							<i class="fas fa-network-wired"></i>แผนกงาน
						</a>
					</li>
					<li>
						<a class="collapsible-header waves-effect arrow-r" href="<?php echo base_url('service');?>">
							<i class="fas fa-address-book"></i>รายการติดต่อ
						</a>
					</li>
					<li>
						<a class="collapsible-header waves-effect arrow-r" href="<?php echo base_url('staff');?>">
							<i class="fas fa-users-cog"></i>เจ้าหน้าที่
						</a>
					</li>
					<li>
						<a class="collapsible-header waves-effect arrow-r" href="<?php echo base_url('status');?>">
							<i class="fas fa-shield-check"></i>สถานะคิว
						</a>
					</li>
					<li>
						<a class="collapsible-header waves-effect arrow-r" href="<?php echo base_url('system_status');?>">
							<i class="far fa-toggle-on"></i>สถานะระบบ
						</a>
					</li>

					<!-- Side navigation links -->
				</ul>
				<div class="sidenav-bg mask-strong"></div>
	</div>
	<!-- Sidebar navigation -->

	<!-- Navbar -->
	<nav class="navbar fixed-top navbar-expand-lg scrolling-navbar stylish-color-dark double-nav">
		<div class="float-left">
			<a href="#" data-activates="slide-out" class="button-collapse text-white" id="btn_sideNav"><i class="fas fa-bars"></i></a>
		</div>
		<div class="breadcrumb-dn mr-auto">
			<span class="text-headder">&nbsp;&nbsp;ระบบบัตรคิวอิเล็กทรอนิกส์</span>
		</div>
		<ul class="navbar-nav ml-auto nav-flex-icons">
			<li class="nav-item avatar dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
				   aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo base_url('assets/images/profiles/'.$_SESSION['user']->profile)?>" class="rounded-circle z-depth-0" alt="avatar image">
				</a>
				<div class="dropdown-menu dropdown-menu-lg-right dropdown-dark"
					 aria-labelledby="navbarDropdownMenuLink-55">
					<label class="mb-0 p-2" style="font-size: 14.4px;"><?php echo $_SESSION['user']->fname." ".$_SESSION['user']->lname ?></label>
					<hr class="mb-1 mt-1">
					<a class="dropdown-item" href="<?php echo base_url('login/logout/')?>"><i class="far fa-sign-out-alt"></i> ออกจากระบบ</a>
				</div>
			</li>
		</ul>
	</nav>
	<!-- Navbar -->

</header>
<!-- Main Navigation -->
