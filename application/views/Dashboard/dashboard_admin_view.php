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
		<div class="card col-sm-12 mb-5">
			<div class="card-body">
				<div class="row mt-3">
					<div class="col-sm-12 mb-2 text-center">
						<h4 class="h4-responsive text-center font-weight-bold ">
							กราฟแสดงสถิติคิว
						</h4>
					</div>
					<div class="col-sm-12 text-center">
						<canvas id="myChart"  style="max-width: 600px;display: inline;"></canvas>
					</div>
				</div>
				<div class="row mt-4 mb-2">
					<div class="col-sm-12 text-center">
						<h5 class="h4-responsive text-center  font-weight-bold ">
							พิมพ์ประวัติ
						</h5>
					</div>
				</div>
				<div class="row justify-content-md-center mb-3">
					<div class="col-sm-4 col-lg-4">
						<div class="row">
							<div class="col-sm-4 offset-lg-1 text-right" id="col_dateFrom">
								<label>ตั้งแต่วันที่</label>
							</div>
							<div class="col-sm-7">
								<div class="md-form mt-0">
									<input placeholder="กรุณาเลือกวันที่" type="text" id="dateFrom" class="form-control py-0 datepicker">
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-lg-4">
						<div class="row">
							<div class="col-sm-2">
								<label>ถึง</label>
							</div>
							<div class="col-sm-7">
								<div class="md-form mt-0">
									<input placeholder="กรุณาเลือกวันที่" type="text" id="dateTo" class="form-control py-0 datepicker">
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-md-3 col-lg-2">
						<button class="btn btn-rounded btn-sm btn-success btn-block waves-effect btn-text"onclick="downLoadQueueLogsReport()" id="btn_print" disabled><i class="fas fa-print"></i> พิมพ์</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Table with panel -->
		<div class="card card-cascade narrower">
			<div class="view view-cascade gradient-card-header blue-gradient narrower py-3 mx-4 mb-4">
				<div class="row">
					<div class="col-sm-10 text-left">
						<label>ประวัติบัตรคิวอิเล็กทรอนิกส์</label>
					</div>
				</div>
			</div>
			<div class="px-4 mb-2">
				<div class="table-wrapper ">
					<!--Table-->
					<table id="dtb_queue" class="table table-hover" cellspacing="0" width="100%">
						<thead class="text-center">
						<tr>
							<th class="th-sm">คิว</th>
							<th class="th-sm">แผนกงาน</th>
							<th class="th-sm">ประเภทผู้ใช้งาน</th>
							<th class="th-sm">รายการติดต่อ</th>
							<th class="th-sm">หมายเลขโทรศัพท์มือถือ</th>
							<th class="th-sm">วันที่เข้าใช้บริการ</th>
							<th class="th-sm">สถานะ</th>
							<th class="th-sm">เวลที่ใช้งาน(นาที)</th>
							<th class="th-sm">เจ้าหน้าที่ที่ให้บริการ</th>
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
<!-- Moment js -->
<script type="text/javascript" src="<?php echo base_url('node_modules/moment/moment.js')?>"></script>
<!-- Chart js -->
<script type="text/javascript" src="<?php echo base_url('node_modules/chart.js/dist/Chart.min.js')?>"></script>
<!-- dataTable JavaScript -->
<script type="text/javascript" src="<?php echo base_url('themes/MDB-Admin/js/addons/datatables.js')?>"></script>
<!-- Booking JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/dashboard_admin.js')?>"></script>
