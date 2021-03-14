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
						<label>รายการติดต่อ</label>
					</div>
				</div>
			</div>
			<div class="px-4 mb-2">
				<div class="table-wrapper ">
					<!--Table-->
					<table id="dtb_service" class="table table-hover table-bordered" cellspacing="0" width="100%">
						<span class="table-add float-right mt-3 text-success">
							<i class="fas fa-plus fa-2x" aria-hidden="true" id="btn_add" title="เพิ่มข้อมูล" onclick="show_modalService('')"></i>
						</span>
						<thead class="text-center">
						<tr>
							<th class="th-sm">รหัสรายการติดต่อ</th>
							<th class="th-sm">ชื่อรายการติดต่อ</th>
							<th class="th-sm">เวลาในการใช้งาน(นาที)</th>
							<th class="th-sm">แผนกงาน</th>
							<th class="th-sm">จัดการประเภทรายการ</th>
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
	<div class="modal fade backdrop-color" id="modal_service" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="false" data-keyboard="false">
		<div class="modal-dialog  modal-dialog-centered cascading-modal" role="document">
			<!--Content-->
			<div class="modal-content">
				<!--Modal cascading tabs-->
				<div class="modal-c-tabs">
					<!-- Nav tabs -->
					<div class="nav nav-tabs md-tabs gradient-card-header blue-gradient-invert lighten-1 py-3" role="tablist">
						<div class="col-sm-12 text-center">
							<h5 class="h2-responsive mb-0 text-white" id="lbl_modal">เพิ่มรายการติดต่อ</h5>
						</div>
					</div>
					<div class="container mb-3">
						<form class="needs-validation" id="form_service" style="color: #757575;" action="#!" novalidate>
							<div class="md-form">
								<input type="text" id="id" placeholder=" " class="form-control text-left">
								<label for="form1">รหัสรายการติดต่อ</label>
							</div>
							<div class="md-form">
								<input type="text" id="name" placeholder=" " class="form-control text-left" required>
								<label for="form1">ชื่อรายการติดต่อ</label>
								<div class="invalid-feedback">
									กรุณากรอกชื่อรายการติดต่อ
								</div>
							</div>
							<div class="md-form">
								<input type="number" id="time" placeholder=" " class="form-control text-left" min="1" max="60" required>
								<label for="form1">เวลาในการใช้งาน(นาที)</label>
								<div class="invalid-feedback">
									กรุณากรอกเวลาในการใช้งานตั้งแต่ 1-60 (นาที)
								</div>
							</div>
							<div class="md-form" id="select_dept">
								<select class="mdb-select" id="department" data-visible-options="-1">
									<option value="" disabled selected>เลือกแผนกงาน</option>
								</select>
							</div>
							<div class="row">
								<div class="col-sm-6 col-6">
									<button type="button" class="btn btn-block btn-outline-success waves-effect" id="btn_save_service">บันทึก</button>
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
<script type="text/javascript" src="<?php echo base_url('assets/js/service.js')?>"></script>
