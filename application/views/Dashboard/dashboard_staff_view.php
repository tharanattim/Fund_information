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
	<link rel="stylesheet" href="<?php echo base_url('assets/css/staff.css')?>">
	<!-- Fonts -->
	<link rel="stylesheet" href="<?php echo base_url('assets/fonts/Kanit/font-kanit.css')?>">

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
							<i class="fas fa-home-lg-alt"></i>หน้าแรก
						</a>
					</li>
					<li>
						<a class="collapsible-header waves-effect arrow-r">
							<i class="fas fa-network-wired"></i></i>แผนกงาน<i class="fas fa-angle-down rotate-icon"></i>
						</a>
						<div class="collapsible-body">
							<ul>
								<li>
									<a class="waves-effect" href="<?php echo base_url('queue/queueDeptRegis');?>">ทะเบียนนักศึกษา</a>
								</li>
								<li>
									<a class="waves-effect" href="<?php echo base_url('queue/queueDeptCheck');?>">ตรวจสอบและรับรองผลการศึกษา</a>
								</li>
								<li>
									<a class="waves-effect" href="<?php echo base_url('queue/queueDeptSuccess');?>">สำเร็จการศึกษา</a>
								</li>
							</ul>
						</div>
					</li>
					<!-- Side navigation links -->
				</ul>
			</li>
		</ul>
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
				<div class="dropdown-menu dropdown-menu-lg-right dropdown-dark" aria-labelledby="navbarDropdownMenuLink-55">
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

<!-- Main layout -->
<main>
	<!-- Loading Page -->
	<div id="loading-page" class="flex-center">
		<div class="preloader-wrapper big active crazy">
			<div class="spinner-layer spinner-blue-only">
				<div class="circle-clipper left">
					<div class="circle"></div>
				</div>
				<div class="gap-patch">
					<div class="circle"></div>
				</div>
				<div class="circle-clipper right">
					<div class="circle"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Page -->
	<div class="container-fluid mb-5">
		<section class="mb-5">
			<!-- Grid row -->
			<div class="row">
				<!-- Grid column -->
				<div class="col-xl-4 col-md-12 mb-xl-0 mb-4">
					<!-- Card -->
					<div class="card card-cascade cascading-admin-card">
						<!-- Card Data -->
						<div class="admin-up">
							<label class="far primary-color text-numqueue">ทะเบียนนักศึกษา</label>
							<div class="data">
								<label class="text-uppercase">คิวทั้งหมด</label>
								<h2 class="font-weight-bold dark-grey-text"><label id="lbl_sumq_dept1"></label></h2>
							</div>
						</div>
						<!-- Card content -->
						<div class="card-body card-body-cascade">
							<div class="progress mb-3">
								<div class="progress-bar bg-primary" role="progressbar" id="progress_dept1" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<label class="card-text">เสร็จสิ้นแล้ว <label id="lbl_successq_dept1"></label> คิว</label>
						</div>
					</div>
					<!-- Card -->
				</div>
				<!-- Grid column -->
				<!-- Grid column -->
				<div class="col-xl-4 col-md-12 mb-xl-0 mb-4">
					<!-- Card -->
					<div class="card card-cascade cascading-admin-card">
						<!-- Card Data -->
						<div class="admin-up">
							<label class="far success-color text-numqueue">ตรวจสอบและรับรองผลการศึกษา</label>
							<div class="data">
								<label class="text-uppercase">คิวทั้งหมด</label>
								<h2 class="font-weight-bold dark-grey-text"><label id="lbl_sumq_dept2"></label></h2>
							</div>
						</div>
						<!-- Card content -->
						<div class="card-body card-body-cascade">
							<div class="progress mb-3">
								<div class="progress-bar bg-primary" role="progressbar" id="progress_dept2" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<label class="card-text">เสร็จสิ้นแล้ว <label id="lbl_successq_dept2"></label> คิว</label>
						</div>
					</div>
					<!-- Card -->
				</div>
				<!-- Grid column -->
				<!-- Grid column -->
				<div class="col-xl-4 col-md-12 mb-md-0 mb-4">
					<!-- Card -->
					<div class="card card-cascade cascading-admin-card">
						<!-- Card Data -->
						<div class="admin-up">
							<label class="far warning-color text-numqueue">สำเร็จการศึกษา</label>
							<div class="data">
								<label class="text-uppercase">คิวทั้งหมด</label>
								<h2 class="font-weight-bold dark-grey-text"><label id="lbl_sumq_dept3"></label></h2>
							</div>
						</div>
						<!-- Card content -->
						<div class="card-body card-body-cascade">
							<div class="progress mb-3">
								<div class="progress-bar bg-primary" role="progressbar" id="progress_dept3" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<label class="card-text">เสร็จสิ้นแล้ว <label id="lbl_successq_dept3"></label> คิว</label>
						</div>
					</div>
					<!-- Card -->
				</div>
				<!-- Grid column -->
			</div>
			<!-- Grid row -->
		</section>
		<div class="card mb-4">
			<div class="card-body ">
				<h4 class="h4-responsive text-center mb-3 font-weight-bold ">
					สถิติการเข้าใช้บริการแต่ละแผนกงาน
				</h4>
				<div class="col-sm-12 text-center">
					<canvas id="doughnutChart"  style="max-width: 800px; min-width: 300px;display: inline;"></canvas>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- Main layout -->

<!-- SCRIPTS -->
<!-- JQuery -->
<script src="<?php echo base_url('node_modules/jquery/dist/jquery.min.js')?>"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/popper.min.js')?>"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/mdb.min.js')?>"></script>
<!-- dataTable JavaScript -->
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/addons/datatables.js')?>"></script>
<!-- Moment js -->
<script type="text/javascript" src="<?php echo base_url('node_modules/moment/moment.js')?>"></script>
<!-- Booking JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/dashboard_staff.js')?>"></script>
