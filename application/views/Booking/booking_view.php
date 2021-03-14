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
		<section class="mb-5">
			<div class="card card-cascade narrower">
				<section>
					<div class="row">
						<div class="col-xl-12 col-lg-12 mr-0 pb-2">
							<div class="view view-cascade gradient-card-header blue-gradient lighten-1">
								<h5 class="h2-responsive mb-0 ">บัตรคิว</h5>
							</div>
							<div class="card-body card-body-cascade pb-0">
								<form class="needs-validation" id="form_booking" style="color: #757575;" action="#!" novalidate>
									<div class="md-form">
										<select class="select-simple form-control" id="usertype" required>
											<option value="" disabled selected>เลือกประเภทผู้ใช้งาน</option>
										</select>
										<div class="invalid-feedback">
											กรุณาเลือกประเภทผู้ใช้งาน
										</div>
									</div>
									<div class="md-form">
										<select class="select-simple form-control" id="department" required>
											<option value="" disabled selected>เลือกแผนกงาน</option>
										</select>
										<div class="invalid-feedback">
											กรุณาเลือกแผนกงาน
										</div>
									</div>
									<div class="md-form">
										<select class="select-simple form-control"  id="service"  required>
											<option value="" disabled selected>เลือกรายการที่ใช้ติดต่อ</option>
										</select>
										<div class="invalid-feedback">
											กรุณาเลือกรายการที่ใช้ติดต่อ
										</div>
									</div>
									<div class="md-form">
										<label  for="phonenumber">หมายเลขโทรศัพท์</label>
										<input type="tel" class="form-control" id="phonenumber" required maxlength = "10" pattern="^0([8|9|6])([0-9]{8}$)">
										<div class="invalid-feedback">
											กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง
										</div>
									</div>
								</form>
								<button class="btn  btn-success btn-block z-depth-0 mt-4 mb-2 waves-effect btn-text btn-padding-y"  id="btn_booking">จองคิว</button>
								<button class="btn  btn-mdb-color btn-block z-depth-0 mb-4 waves-effect btn-text btn-padding-y"  id="btn_reset">ยกเลิก</button>
								<hr width="100%">
								<button class="btn btn-info  btn-block  z-depth-0 my-2 mb-4 waves-effect btn-text btn-padding-y" id="btn_check_queue" >ตรวจสอบคิวของท่าน</button>
							</div>
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>

	<!-- modal check booking -->
	<div class="modal fade backdrop-color" id="modal_booking" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="false" data-keyboard="false">
		<div class="modal-dialog  modal-dialog-centered cascading-modal" role="document" >
			<!--Content-->
			<div class="modal-content">
				<!--Modal cascading tabs-->
				<div class="modal-c-tabs">
					<!-- Nav tabs -->
					<div class="nav nav-tabs md-tabs gradient-card-header blue-gradient-invert lighten-1 py-3" role="tablist">
						<div class="col-sm-12 text-center">
							<h5 class="h2-responsive mb-0 text-white">บัตรคิว</h5>
						</div>
					</div>
					<!-- Tab panels -->
					<div class="tab-content">
						<!--Panel 7-->
						<div class="tab-pane fade in show active" id="panel7" role="tabpanel">
							<div class="container mb-3">
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>คิวที่กำลังใช้งาน</label>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<label id="lbl_curent_queue"></label>
									</div>
								</div>
								<hr width="100%" class="mt-0"><br>
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>คิวของคุณ</label>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<label id="lbl_your_queue"></label>
									</div>
								</div>
								<hr width="100%" class="mt-0"><br>
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>จำนวนที่รอ(คิว)</label>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<label id="lbl_count_queue"></label>
									</div>
								</div>
								<hr width="100%" class="mt-0"><br>
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>เวลารอโดยประมาณ</label>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<label id="lbl_waiting_time"></label>
									</div>
								</div>
								<hr width="100%" class="mt-0">
								<label class="text-danger" style="font-size: 14px">*กรุณาเลือกปุ่ม ยืนยันการจองคิว เพื่อสร้างบัตรคิวของท่าน</label>
							<!--Footer-->
								<div class="row mt-2">
									<div class="col-sm-6 col-6">
										<button type="button" class="btn btn-block btn-outline-success waves-effect" id="btn_confirm" onclick="confirm_booking()">ยืนยันการจองคิว</button>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<button type="button" class="btn btn-block btn-outline-danger waves-effect" id="btn_cancel">ยกเลิกการจองคิว</button>
									</div>
								</div>
							</div>
						</div>
						<!--/.Panel 7-->
					</div>
				</div>
			</div>
			<!--/.Content-->
		</div>
	</div>
	<!-- modal check booking -->

	<!-- modal confirm booking -->
	<div class="modal fade backdrop-color" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="false" data-keyboard="false">
		<div class="modal-dialog  modal-dialog-centered cascading-modal" role="document">
			<!--Content-->
			<div class="modal-content">
				<!--Modal cascading tabs-->
				<div class="modal-c-tabs">
					<!-- Nav tabs -->
					<div class="nav nav-tabs md-tabs gradient-card-header blue-gradient-invert lighten-1 py-3" role="tablist">
						<div class="col-sm-12 text-center">
							<h5 class="h2-responsive mb-0 text-white">บัตรคิว</h5>
						</div>
					</div>
					<!-- Tab panels -->
					<div class="tab-content">
						<!--Panel 7-->
						<div class="tab-pane fade in show active" id="panel7" role="tabpanel">
							<div class="container mb-3">
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>คิวที่กำลังใช้งาน</label>
									</div>
									<div class="col-sm-6 col-6 text-center">
										<label class="animated zoomIn infinite" style="font-size: 20px; color: green; display: none;" id="lbl_your_queue_anima" disabled="">คิวของคุณ</label>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 col-6 ">
										<label id="lbl_s_curent_queue"></label>
									</div>
								</div>
								<hr width="100%">
								<div class="row">
									<div class="col-sm-6 col-6 linetung text-center" >
										<label >คิวของคุณ</label>
									</div>
									<div class="col-sm-6 col-6 text-center">
										<label>จำนวนที่รอ(คิว)</label>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 col-6 linetung font-30 text-center">
										<label id="lbl_s_your_queue"></label>
									</div>
									<div class="col-sm-6 col-6 font-30 text-center">
										<label id="lbl_s_count_queue"></label>
									</div>
								</div>
								<hr width="100%">
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>เวลารอโดยประมาณ</label>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<label id="lbl_s_waiting_time" style="font-size: 25px" ></label>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>แผนกงาน</label>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<label id="lbl_s_department"></label>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 col-6">
										<label>รายการติดต่อ</label>
									</div>
									<div class="col-sm-6 col-6 text-right">
										<label id="lbl_s_service"></label>
									</div>
								</div>
								<hr width="100%">
								<!--Footer-->
								<div class="row">
									<div class="col-sm-12 col-12 text-center">
										<button type="button" class="btn btn-outline-danger waves-effect" onclick="cancelQueue()" id="btn_cancel_queue">ยกเลิกการจองคิว</button>
									</div>
								</div>
							</div>
						</div>
						<!--/.Panel 7-->
					</div>
				</div>
			</div>
			<!--/.Content-->
		</div>
	</div>
	<!-- modal check booking -->
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
<!-- Moment js -->
<script type="text/javascript" src="<?php echo base_url('node_modules/moment/moment.js')?>"></script>
<!-- Select 2 JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/select2/dist/js/select2.full.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('node_modules/select2/dist/js/pmd-select2.js')?>"></script>
<!-- Sweet Alert JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<!-- Booking JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/booking.js')?>"></script>

