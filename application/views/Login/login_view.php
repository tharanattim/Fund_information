<script>
	var base_url = '<?php echo base_url();?>';
</script>
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

	<div class="container-fluid">
		<section>
			<div class="row">
				<!-- Grid column -->
				<div class="col-sm-12 mt-5">
					<!--Form with header -->
					<div class="card">
						<div class="card-body">
							<!--Header -->
							<div class="form-header blue-gradient lighten-1" style="font-family: Kanit-Medium">
								<h5>เข้าสู่ระบบจัดการระบบบัตรคิวอิเล็กทรอนิกส์</h5>
							</div>
							<form class="needs-validation" id="form_login" style="color: #757575;" action="#!" novalidate>
								<!--Body -->
								<div class="md-form">
									<i class="fas fa-user prefix grey-text"></i>
									<input type="text" id="username" class="form-control" required>
									<label for="username">บัญชีผู้ใช้งาน</label>
									<div class="invalid-feedback">
										กรุณากรอกชื่อบัญชีผู้ใช้งาน
									</div>
								</div>
								<div class="md-form">
									<i class="fas fa-unlock-alt prefix grey-text"></i>
									<input type="password" id="password" class="form-control" required>
									<label for="password">รหัสผ่าน</label>
									<div class="invalid-feedback">
										กรุณากรอกรหัสผ่าน
									</div>
								</div>
							</form>
							<div class="row">
								<div class="col-sm-12">
									<div class="text-center mt-4">
										<button type="button" class="btn btn-sm btn-block btn-success btn-text" id="btn_login" style="font-family: Kanit-Regular">เข้าสู่ระบบ</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--Form with header -->
				</div>
			</div>
		</section>
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
<!-- Sweet Alert JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<!-- Booking JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/login.js')?>"></script>
