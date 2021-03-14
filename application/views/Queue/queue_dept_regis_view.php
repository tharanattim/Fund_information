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
	<!-- Sweet Alert -->
	<link rel="stylesheet" href="<?php echo base_url('node_modules/sweetalert2/dist/sweetalert2.min.css')?>">
	<!-- Fonts -->
	<link rel="stylesheet" href="<?php echo base_url('assets/fonts/Kanit/font-kanit.css')?>">

	<script>
		var user_dept = <?php echo $_SESSION['user']->department;?>.toString().padStart(2, "0");
	</script>

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
						<a class="collapsible-header waves-effect arrow-r active" >
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
				<div class="fixed-bottom text-center">
					<hr style="noshade color: white">
					<div class="col-sm-12 mb-4">
						<div class="switch">
							<label style="font-size: 12px;">
								<i class="fal fa-lock-alt"></i> ปิดระบบ
								<input type="checkbox" id="dept_regis_status" disabled>
								<span class="lever"></span> <i class="fal fa-lock-open-alt"></i> เปิดระบบ
							</label>
						</div>
					</div>
				</div>
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
				<div class="dropdown-menu dropdown-menu-lg-right dropdown-dark"
					 aria-labelledby="navbarDropdownMenuLink-55">
					<label class="mb-0 p-2" style="font-size: 14.4px;" id="lbl_staff_name"><?php echo $_SESSION['user']->fname." ".$_SESSION['user']->lname ?></label>
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
			<div class="row">
				<div class="col-sm-12 col-xl-6">
					<div class="card card-cascade narrower">
						<div class="view view-cascade primary-color  narrower py-3 mx-4 mb-4 white-text">
							<div class="row">
								<div class="col-sm-6 col-6 hr-white text-center" >
									<label><i class="fad fa-clipboard-list"></i> ลำดับคิว</label>
								</div>
								<div class="col-sm-6 col-6 text-center">
									<label><i class="fad fa-spinner-third"></i> สถานะ</label>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-6 hr-white text-center">
									<label class="font-30" id="lbl_queue_no" data-queueno="">-</label>
								</div>
								<div class="col-sm-6 col-6 text-center">
									<label class="font-30" id="lbl_status">กำลังใช้งาน</label>
								</div>
							</div>
						</div>
						<div class="px-4 mb-2">
							<div class="row">
								<div class="col-sm-6 col-6">
									<label>ประเภทผู้ใช้งาน</label>
								</div>
								<div class="col-sm-6 col-6 text-right">
									<label id="lbl_user_type">-</label>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-6">
									<label>หมายเลขโทรศัพท์</label>
								</div>
								<div class="col-sm-6 col-6 text-right">
									<label id="lbl_phone_number">-</label>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-6">
									<label>รายการติดต่อ</label>
								</div>
								<div class="col-sm-6 col-6 text-right">
									<label id="lbl_service_name">-</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Grid column -->
				<div class="col-sm-8 col-xl-4">
					<!-- Card -->
					<div class="card " style="margin-top: 1.3rem">
						<!-- Card Data -->
						<div class="row mt-4" style="margin-bottom: 1rem">
							<div class="col-md-3 col-3 text-left pl-4">
								<a class="p-2 m-2 fa-lg fb-ic"><i class="far fa-clock fa-2x blue-text"></i></a>
							</div>
							<div class="col-md-9 col-9 text-right pr-5">
								<div class="row">
									<div class="col-sm-12">
										<label class="font-small grey-text mb-1">เวลาปัจจุบัน</label>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<h5 class="mb-1 font-weight-bold"><label id="lbl_time_now"></label> น.</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- Card Data -->
					</div>
					<!-- Card -->
					<!-- Card -->
					<div class="card mt-4">
						<!-- Card Data -->
						<div class="row mt-3 mb-3">
							<div class="col-md-3 col-3 text-left pl-4 pt-3">
								<a class="p-2 m-2 fa-lg fb-ic"><i class="far fa-stopwatch fa-2x green-text"></i></a>
							</div>
							<div class="col-md-9 col-9 text-right pr-5">
								<div class="row">
									<div class="col-sm-12">
										<label class="font-small grey-text mb-1">เวลาแล้วเสร็จโดยประมาณ</label>
									</div>
								</div>
								<div class="row pr-2">
									<div class="col-5 col-sm-5 col-md-4 col-lg-3 col-xl-5 offset-6  offset-sm-7 offset-lg-8 offset-xl-6 pr-1">
										<div class="md-form my-0 pl-3">
											<input placeholder="00:00" type="text" id="success_time" class="form-control pt-0 font-time-success" disabled>
										</div>
									</div>
									<div class="col-sm-1 col-md-1 col-1 text-left px-0">
										<h5 class="mb-1 font-weight-bold"> น.</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- Card Data -->
					</div>
					<!-- Card -->
				</div>
				<!-- Grid column -->
				<div class="col-sm-4 col-xl-2">
					<!-- Card -->
					<div class="card mt-4 p-2">
						<div class="row my-2">
							<div class="col-sm-12">
								<button class="btn btn-rounded btn-primary btn-block waves-effect btn-text" id="btn_next" onclick="nextQueue()" disabled>คิวต่อไป</button>
							</div>
						</div>
						<div class="row my-2">
							<div class="col-sm-12">
								<button class="btn btn-rounded btn-danger btn-block waves-effect btn-text" id="btn_cancel" onclick="cancelQueue()" disabled>ยกเลิกคิว</button>
							</div>
						</div>
						<div class="row my-2">
							<div class="col-sm-12">
								<button class="btn btn-rounded btn-grey btn-block waves-effect btn-text" id="btn_pause" onclick="pauseQueue()" disabled>พักคิว</button>
							</div>
						</div>
					</div>
					<!-- Card -->
				</div>
				<!-- Grid column -->
			</div>
		</section>
		<!-- Table with panel -->
		<div class="card card-cascade narrower">
			<div class="view view-cascade gradient-card-header blue-gradient narrower py-3 mx-4 mb-4">
				<div class="row">
					<div class="col-sm-6 text-left">
						<label>แผนกงานทะเบียนนักศึกษา</label>
					</div>
					<div class="col-sm-6 text-right" id="col_lbl_queue">
						<label id="lbl_queue_length"></label>
					</div>
				</div>
			</div>
			<div class="px-4 mb-2">
				<div class="table-wrapper ">
					<!--Table-->
						<table id="dtb_queue" class="table table-hover" cellspacing="0" width="100%">
							<thead class="text-center">
							<tr>
								<th class="th-sm">ลำดับคิว</th>
								<th class="th-sm">ประเภทผู้ใช้งาน</th>
								<th class="th-sm">รายการติดต่อ</th>
								<th class="th-sm">หมายเลขโทรศัพท์มือถือ</th>
								<th class="th-sm">สถานะ</th>
								<th class="th-sm">เวลารอคิวโดยประมาณ(นาที)</th>
							</tr>
							</thead>
							<tbody class="text-center">
							</tbody>
						</table>
						<!--Table-->
				</div>
			</div>
		</div>
		<!-- Table with panel -->
	</div>

	<!-- Modal_pauseQueue-->
	<div class="modal fade backdrop-color" id="modal_pausequeue" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="false" data-keyboard="false">
		<div class="modal-dialog  modal-dialog-centered cascading-modal" role="document">
			<!--Content-->
			<div class="modal-content">
				<!--Modal cascading tabs-->
				<div class="modal-c-tabs">
					<!-- Nav tabs -->
					<div class="nav nav-tabs md-tabs gradient-card-header blue-gradient-invert lighten-1 py-3" role="tablist">
						<div class="col-sm-12 text-center">
							<h5 class="h2-responsive mb-0 text-white" id="lbl_modal">พักคิว</h5>
						</div>
					</div>
					<div class="container mb-3">
						<form class="needs-validation" id="form_pause"  style="color: #757575;" action="#!" novalidate>
							<div class="md-form" id="select_time">
								<select class="mdb-select" id="time_pause" data-visible-options="-1" required>
									<option value="" disabled selected>เลือกเวลาที่ต้องการ</option>
									<option value="5">5 นาที</option>
									<option value="10">10 นาที</option>
									<option value="15">15 นาที</option>
									<option value="30">30 นาที</option>
									<option value="45">45 นาที</option>
									<option value="60">60 นาที</option>
								</select>
								<div class="invalid-feedback">
									กรุณาเลือกเวลาที่ต้องการ
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-6">
									<button type="button" class="btn btn-block btn-outline-success waves-effect" id="btn_pause_queue">ตกลง</button>
								</div>
								<div class="col-sm-6 col-6 text-right">
									<button type="button" class="btn btn-block btn-outline-danger waves-effect" id="btn_cancel_pause" data-dismiss="modal">ยกเลิก</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--/.Content-->
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
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/mdb.js')?>"></script>
<!-- dataTable JavaScript -->
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/addons/datatables.js')?>"></script>
<!-- Moment js -->
<script type="text/javascript" src="<?php echo base_url('node_modules/moment/moment.js')?>"></script>
<!-- Sweet Alert JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<!-- Booking JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/queue_dept_regis.js')?>"></script>
