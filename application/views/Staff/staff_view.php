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
						<label>เจ้าหน้าที่</label>
					</div>
				</div>
			</div>
			<div class="px-4 mb-2">
				<div class="table-wrapper">
					<!--Table-->
					<table id="dtb_staff" class="table table-hover table-bordered" cellspacing="0" width="100%"  >
						<span class="table-add float-right mt-3 text-success">
							<i class="fas fa-plus fa-2x" aria-hidden="true" id="btn_add" title="เพิ่มข้อมูล" onclick="show_modalStaff('')"></i>
						</span>
						<thead class="text-center">
						<tr>
							<th class="th-sm">รหัสเจ้าหน้าที่</th>
							<th class="th-sm">ชื่อ</th>
							<th class="th-sm">นามสกุล</th>
							<th class="th-sm">ตำแหน่ง</th>
							<th class="th-sm">ชื่อผู้ใช้</th>
							<th class="th-sm">แผนกงาน</th>
							<th class="th-sm">จัดการเจ้าหน้าที่</th>
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

	<!-- Modal -->
	<div class="modal fade backdrop-color" id="modal_staff" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="false" data-keyboard="false">
		<div class="modal-dialog  modal-dialog-centered cascading-modal" role="document">
			<!--Content-->
			<div class="modal-content">
				<!--Modal cascading tabs-->
				<div class="modal-c-tabs">
					<!-- Nav tabs -->
					<div class="nav nav-tabs md-tabs gradient-card-header blue-gradient-invert lighten-1 py-3" role="tablist">
						<div class="col-sm-12 text-center">
							<h5 class="h2-responsive mb-0 text-white" id="lbl_modal">เพิ่มเจ้าหน้าที่</h5>
						</div>
					</div>
					<div class="container mb-3">
						<form class="needs-validation" id="form_staff" style="color: #757575;" action="#!" novalidate>
							<div class="md-form">
								<input type="text" id="id" placeholder=" " class="form-control text-left">
								<label for="form1">รหัสเจ้าหน้าที่</label>
							</div>
							<div class="md-form">
								<input type="text" id="fname" placeholder=" " class="form-control text-left" required>
								<label for="form1">ชื่อ</label>
								<div class="invalid-feedback">
									กรุณากรอกชื่อ
								</div>
							<div class="md-form">
								<input type="text" id="lname" placeholder=" " class="form-control text-left" required>
								<label for="form1">นามสกุล</label>
								<div class="invalid-feedback">
									กรุณากรอกนามสกุล
								</div>
							</div>
							<div class="md-form">
								<input type="text" id="pos" placeholder=" " class="form-control text-left" required>
								<label for="form1">ตำแหน่ง</label>
								<div class="invalid-feedback">
									กรุณากรอกตำแหน่ง
								</div>
							</div>
							<div class="md-form" id="select_dept">
								<select class="mdb-select" id="department" data-visible-options="-1">
									<option value="" disabled selected>เลือกแผนกงาน</option>
								</select>
							</div>
							<div class="md-form">
								<input type="text" id="username" placeholder=" " class="form-control text-left" required>
								<label for="form1">ชื่อผู้ใช้</label>
								<div class="invalid-feedback">
									กรุณากรอกชื่อผู้ใช้
								</div>
							</div>
							<div class="md-form mb-4">
								<input type="password" id="password" placeholder=" " class="form-control text-left" required>
								<label for="form1">รหัสผ่าน</label>
								<div class="invalid-feedback">
									กรุณากรอกรหัสผ่าน
								</div>
							</div>
						</form>
						<form action="<?= base_url('/staff/uploadProfiles') ?>" class="dropzone mb-4 text-center dropzone-padding" id='profile'></form>
						<div class="row">
							<div class="col-sm-6 col-6">
								<button type="button" class="btn btn-block btn-outline-success waves-effect" id="btn_save_staff">บันทึก</button>
							</div>
							<div class="col-sm-6 col-6 text-right">
								<button type="button" class="btn btn-block btn-outline-danger waves-effect" onclick="resetModal()">ยกเลิก</button>
							</div>
						</div>
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
<!-- Sweet Alert JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<!-- Dropzone JavaScript -->
<script type="text/javascript" src="<?php echo base_url('node_modules/dropzone-5.7.0/dist/min/dropzone.min.js')?>"></script>
<!-- Booking JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/staff.js')?>"></script>
