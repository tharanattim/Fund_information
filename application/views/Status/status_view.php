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
		<div class="card card-cascade narrower">
			<div class="view view-cascade gradient-card-header blue-gradient narrower py-3 mx-4 mb-4">
				<div class="row">
					<div class="col-sm-10 text-left">
						<label>สถานะ</label>
					</div>
				</div>
			</div>
			<div class="px-4 mb-2">
				<div class="table-wrapper ">
					<!--Table-->
					<table id="dtb_status" class="table table-hover table-bordered" cellspacing="0" width="100%">
						<span class="table-add float-right mt-3 text-success">
							<i class="fas fa-plus fa-2x" aria-hidden="true" id="btn_add" title="เพิ่มข้อมูล" onclick="show_modalStatus('')"></i>
						</span>
						<thead class="text-center">
						<tr>
							<th class="th-sm">รหัสสถานะ</th>
							<th class="th-sm">ชื่อสถานะ</th>
							<th class="th-sm">จัดการสถานะ</th>
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
	<!-- Button trigger modal -->

	<!-- Modal -->
	<div class="modal fade backdrop-color" id="modal_status" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="false" data-keyboard="false">
		<div class="modal-dialog  modal-dialog-centered cascading-modal" role="document">
			<!--Content-->
			<div class="modal-content">
				<!--Modal cascading tabs-->
				<div class="modal-c-tabs">
					<!-- Nav tabs -->
					<div class="nav nav-tabs md-tabs gradient-card-header blue-gradient-invert lighten-1 py-3" role="tablist">
						<div class="col-sm-12 text-center">
							<h5 class="h2-responsive mb-0 text-white" id="lbl_modal">เพิ่มสถานะ</h5>
						</div>
					</div>
					<div class="container mb-3">
						<form class="needs-validation" id="form_status" style="color: #757575;" action="#!" novalidate>
							<div class="md-form">
								<input type="text" id="id" placeholder=" " class="form-control text-left">
								<label for="form1">รหัสสถานะ</label>
							</div>
							<div class="md-form mb-5">
								<input type="text" id="name" placeholder=" " class="form-control text-left" required>
								<label for="form1">ชื่อสถานะ</label>
								<div class="invalid-feedback">
									กรุณากรอกชื่อสถานะ
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-6">
									<button type="button" class="btn btn-block btn-outline-success waves-effect" id="btn_save_status">บันทึก</button>
								</div>
								<div class="col-sm-6 col-6 text-right">
									<button type="button" class="btn btn-block btn-outline-danger waves-effect" onclick="resetModal()">ยกเลิก</button>
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
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/mdb.min.js')?>"></script>
<!-- dataTable JavaScript -->
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/addons/datatables.js')?>"></script>
<!-- Sweet Alert JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<!-- Booking JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/status.js')?>"></script>
