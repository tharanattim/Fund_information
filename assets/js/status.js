var validat;
var table;

$(function () {
	$('#loading-page').show();
	$.when(
		loadSideNav(),
		renderStatus(),
		btnAddAnima(),
		validation_status()
	).done(function () {
		$('#loading-page').hide();
	});
})

function loadSideNav() {
	$("#btn_sideNav").sideNav();
}

function btnAddAnima() {
	$('#btn_add')
		.mouseover(function() {
			$('#btn_add').addClass('animated heartBeat infinite');
		})
		.mouseout(function() {
			$('#btn_add').removeClass('animated heartBeat infinite');
		});
}

function resetModal() {
	$('#lbl_modal').html('เพิ่มแผนกงาน');
	$('#id').prop('disabled',false);
	$('#id').val('');
	setTimeout(function() {
		$("#name").focus();
	}, 500);
	$('#name').val('');
	$('#form_status').removeClass('was-validated');
	$('#modal_status').modal('hide');
}

function loadTable () {
	$('#dtb_dept').DataTable({
		"pagingType": "full_numbers",
		"searching": false,
		"sDom": '<\'row\'<\'col-sm-6\'l>>t<\'row\'<\'col-sm-6\'i><\'col-sm-6\'p>>',
		"oLanguage": {
			"sLengthMenu": "แสดง_MENU_รายการ",
			"sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ"
		}
	});
	$('#dtb_service_wrapper').find('label').each(function () {
		$(this).parent().append($(this).children());
	});
	$('#dtb_service_wrapper .dataTables_filter').find('input').each(function () {
		const $this = $(this);
		$this.attr("placeholder", "Search");
		$this.removeClass('form-control-sm');
	});
	$('#dtb_dept_wrapper .dataTables_length').addClass('d-flex flex-row');
	$('#dtb_dept_wrapper .dataTables_filter').addClass('md-form');
	$('#dtb_dept_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
	$('#dtb_dept_wrapper select').addClass('mdb-select');
	$('#dtb_dept_wrapper .mdb-select').materialSelect();
	$('#dtb_dept_wrapper .dataTables_filter').find('label').remove();
}

function show_modalStatus(id) {
	if(id == ''){
		$.ajax({
			url : "/rmuti-electronicqueue/Status/getIDStatus",
			type : 'GET',
			async : false
		}).done(function(data) {
			$('#form_status').removeClass('was-validated');
			var result = JSON.parse(data);
			$('#lbl_modal').html('เพิ่มสถานะ');
			$('#id').val(result[0].id != null ? (parseInt(result[0].id) + 1).toString().padStart(2, "0") : '01');
			$('#id').prop('disabled',true);
			$('#name').val('');
			setTimeout(function() {
				$("#name").focus();
			}, 500);
			$('#modal_status').modal('show');
		}).fail(function() {
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			})
		});
	}else {
		$('#form_status').removeClass('was-validated');
		$.ajax({
			url : "/rmuti-electronicqueue/Status/getStatusByID/" + id,
			type : 'GET',
			async : false
		}).done(function(data) {
			var result = JSON.parse(data);
			$('#id').val(result[0].id);
			$('#name').val(result[0].status);
			$('#lbl_modal').html('แก้ไขสถานะ');
			$('#id').prop('disabled',true);
			setTimeout(function() {
				$("#name").focus();
			}, 500);
			$('#modal_status').modal('show');
		}).fail(function() {
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			})
		});
	}
}

function validation_status() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#btn_save_status').click(function() {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
				validat = false;
			}else {
				saveOrUpdate();
			}
			form.classList.add('was-validated');
		});
	});
}

function saveOrUpdate(){
	if ($('#lbl_modal').html() == 'เพิ่มสถานะ') {
		var data = {
			"id" : $('#id').val(),
			"status" : $('#name').val()
		}

		$.ajax({
			url : "/rmuti-electronicqueue/Status/saveStatus",
			type : 'POST',
			data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
			contentType: "application/json; charset=utf-8",
			async : false
		}).done(function(data) { //POST สำเร็จ return เป็นจริง
			var result = JSON.parse(data);
			if (result){
				table.ajax.reload(null, false);
				resetModal();
				Swal.fire({
					title: 'เพิ่มข้อมูลสำเร็จ',
					icon: 'success',
					timer: 1000
				})
			}
		}).fail(function() {
			resetModal();
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			})
		});

	}else {
		var data = {
			"status" : $('#name').val()
		}

		$.ajax({
			url : "/rmuti-electronicqueue/Status/updateStatus/" + $('#id').val(),
			type : 'PUT',
			data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
			contentType: "application/json; charset=utf-8",
			async : false
		}).done(function(data) { //POST สำเร็จ return เป็นจริง
			var result = JSON.parse(data);
			if (result){
				table.ajax.reload(null, false);
				$('#form_status')[0].reset();
				resetModal();
				Swal.fire({
					title: 'แก้ไขข้อมูลสำเร็จ',
					icon: 'success',
					timer: 1000
				})
			}
		}).fail(function() {
			resetModal();
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			})
		});
	}
}

function renderStatus() {
	table = $('#dtb_status').DataTable( {
			"processing": true,
			"pagingType": "full_numbers",
			"searching": true,
			"sDom": '<\'row\'<\'col-sm-2\'f>><\'row\'<\'col-sm-12\'t>><\'row\'<\'col-sm-6\'l><\'col-sm-6\'p>>',
			"oLanguage": {
				"sLengthMenu": "แสดง_MENU_รายการ",
				"sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ"
			},
			"ajax": {
				url: "/rmuti-electronicqueue/Status/getStatus",
				dataSrc: ""
			},
			"columns": [
				{ "data": "id" },
				{ "data":"status" },
				{
					data: "id",
					className: "center",
					render: function(data){
						return 	'<button type="button" class="btn btn-primary btn-rounded btn-sm my-0" onclick="show_modalStatus('+ parseInt(data) +')">แก้ไข</button>' +
								'<button type="button" class="btn btn-danger btn-rounded btn-sm my-0" onclick="deleteStatus('+ parseInt(data) +')">ลบ</button>'
					}
				}
			]
		} );

	$('#dtb_status_wrapper').find('label').each(function () {
		$(this).parent().append($(this).children());
	});
	$('#dtb_status_wrapper .dataTables_filter').find('input').each(function () {
		const $this = $(this);
		$this.attr("placeholder", "Search");
		$this.removeClass('form-control-sm');
	});
	$('#dtb_status_wrapper .dataTables_filter').addClass('md-form');
	$('#dtb_status_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
	$('#dtb_status_wrapper select').addClass('custom-select-dtb');
	$('#dtb_status_wrapper .dataTables_filter').find('label').remove();
	$('#dtb_status_filter').removeClass('dataTables_filter ');
	$('#dtb_status_filter').children('input').prop('placeholder', "ค้นหา");
	$('#dtb_status').parent('div .col-sm-12').addClass('table-responsive');
}

function deleteStatus(id) {
	Swal.fire({
		title: 'ยืนยันการลบ',
		text: "คุณต้องการลบสถานะหมายเลข "+ id.toString().padStart(2, "0") +" ?" ,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ตกลง',
		cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url : "/rmuti-electronicqueue/Status/deleteStatus/" + id,
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				if (result === 1){
					table.ajax.reload(null, false);
					Swal.fire({
						title: 'ลบข้อมูลสำเร็จ',
						icon: 'success',
						timer: 1500
					})
				}else {
					Swal.fire({
						title: 'ผิดพลาด',
						text: "ไม่สามารถลบสถานะหมายเลข "+ id.toString().padStart(2, "0") +" ได้" ,
						icon: 'error'
					})
				}
			}).fail(function() {
				Swal.fire({
					title: 'ระบบผิดพลาด',
					text: "ไม่สามารถดำเนินการได้ในขณะนี้",
					icon: 'error'
				})
			});
		}
	})
}

