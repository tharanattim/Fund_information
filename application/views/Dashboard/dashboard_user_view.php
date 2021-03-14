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
	<link rel="stylesheet" href="<?php echo base_url('assets/css/user.css')?>">
	<!-- Fonts -->
	<link rel="stylesheet" href="<?php echo base_url('assets/fonts/Kanit/font-kanit.css')?>">

</head>
<body>
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

	<div class="container-fluid">
		<div class="top-view">
		</div>
		<div class="bottom">
			<div class="content" >
				<div class="row" >
					<div class="col-12">
						<div>
							<img src="<?php echo base_url('assets/images/logo_eq_dashboard.png')?>" width="350px">
						</div>
					</div>
				</div>
				<div class="row pt-4">
					<div class="col-12 pb-2">
						<div class="card card-queue">
							<table class="text-center" style="width: 100%; height: 100%" cellpadding="0">
								<thead>
									<tr>
										<th width="65%"><label class="lbl-text-head">ลำดับคิว</label></th>
										<th width="35%"><label class="lbl-text-head">ช่องบริการ</label></th>
									</tr>
								</thead>
								<tbody>
									<tr>
 										<td><label class="lbl-text-queue" id="lbl_regis">-</label></td>
										<td><label class="lbl-text-queue">1</label></td>
									</tr>
									<tr>
										<td><label class="lbl-text-queue" id="lbl_chack">-</label></td>
										<td><label class="lbl-text-queue">2</label></td>
									</tr>
									<tr>
										<td><label class="lbl-text-queue" id="lbl_success">-</label></td>
										<td><label class="lbl-text-queue">3</label></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>
</body>
</html>

<!-- SCRIPTS -->
<!-- JQuery -->
<script src="<?php echo base_url('node_modules/jquery/dist/jquery.min.js')?>"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/popper.min.js')?>"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<!-- Moment js -->
<script type="text/javascript" src="<?php echo base_url('node_modules/moment/moment.js')?>"></script>
<!-- dashboard_user -->
<script type="text/javascript" src="<?php echo base_url('assets/js/dashboard_user.js')?>"></script>
