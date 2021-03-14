var validat;
var table;

$(function () {
	$('#loading-page').show();
	$.when(
		loadSideNav(),
		renderDepartment(),
		initSelect(),
		btnAddAnima(),
		validation_department()
	).done(function () {
		$('#loading-page').hide();
	});
})

function initSelect() {
	$('#select_system_status .mdb-select').materialSelect();
	$('#select_system_status .mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder", "เลือกสถานะระบบ").prop('required', true).addClass('form-control').css('background-color', '#fff');
}

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
	$('#form_dept').removeClass('was-validated');
	$('#modal_dept').modal('hide');
}

function show_modalDept(id) {
	if(id == ''){
		$.ajax({
			url : "/rmuti-electronicqueue/Department/getIDDepartment",
			type : 'GET',
			async : false
		}).done(function(data) {
			$('#form_dept').removeClass('was-validated');
			var result = JSON.parse(data);
			$('#lbl_modal').html('เพิ่มแผนกงาน');
			$('#id').val(result[0].id != null ? (parseInt(result[0].id) + 1).toString().padStart(2, "0") : '01');
			$('#id').prop('disabled',true);

			$.ajax({
				url : "/rmuti-electronicqueue/Department/getSystem_status",
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				$('#system_status').empty();
				$.each(result, function (i, v) {
					$('#system_status').append('<option value=' + v.id  + '>' + v.status + '</option>');
				});

				setTimeout(function(){
					$('input.select-dropdown.form-control').addClass('text-left');
					$('#select_system_status .mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder", "เลือกสถานะระบบ").prop('required', true).addClass('form-control').css('background-color', '#fff');
				}, 100);
				setTimeout(function() {
					$("#name").focus();
				}, 500);
				$('#modal_dept').modal('show');

			}).fail(function() {
				resetModal();
				Swal.fire({
					title: 'ระบบผิดพลาด',
					text: "ไม่สามารถดำเนินการได้ในขณะนี้",
					icon: 'error'
				})
			});

		}).fail(function() {
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			})
		});
	}else {
		$('#form_dept').removeClass('was-validated');
		$.ajax({
			url : "/rmuti-electronicqueue/Department/getDepartmentByid/" + id,
			type : 'GET',
			async : false
		}).done(function(data) {
			var result = JSON.parse(data);
			var status = result[0].status;
			$('#id').val(result[0].id);
			$('#name').val(result[0].dept_name);
			$('#lbl_modal').html('แก้ไขแผนกงาน');
			$('#id').prop('disabled',true);

			$.ajax({
				url : "/rmuti-electronicqueue/Department/getSystem_status",
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				$('#system_status').empty();
				$.each(result, function (i, v) {
					$('#system_status').append('<option value=' + v.id  + '>' + v.status + '</option>');
				});

				setTimeout(function(){
					$('#system_status').val(status);
					$('input.select-dropdown.form-control').addClass('text-left');
					$('#select_system_status .mdb-select.select-wrapper .select-dropdown').val($('#system_status option:selected').text()).removeAttr('readonly').prop('required', true).addClass('form-control').css('background-color', '#fff');
				}, 100);
				setTimeout(function() {
					$("#name").focus();
				}, 500);
				$('#modal_dept').modal('show');

			}).fail(function() {
				resetModal();
				Swal.fire({
					title: 'ระบบผิดพลาด',
					text: "ไม่สามารถดำเนินการได้ในขณะนี้",
					icon: 'error'
				})
			});

		}).fail(function() {
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			})
		});
	}
}

function validation_department() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#btn_save_department').click(function() {
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
	if ($('#lbl_modal').html() == 'เพิ่มแผนกงาน') {
		var data = {
			"id" : $('#id').val(),
			"dept_name" : $('#name').val(),
			"status": $('#system_status option:selected').val()
		}
		$.ajax({
			url : "/rmuti-electronicqueue/Department/saveDepartment",
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

	}else { //update
		var data = {
			"dept_name" : $('#name').val(),
			"status": $('#system_status option:selected').val()
		}

		$.ajax({
			url : "/rmuti-electronicqueue/Department/updateDepartment/" + $('#id').val(),
			type : 'PUT',
			data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
			contentType: "application/json; charset=utf-8",
			async : false
		}).done(function(data) { //PUT สำเร็จ return เป็นจริง
			var result = JSON.parse(data);
			if (result){
				table.ajax.reload(null, false);
				$('#form_dept')[0].reset();
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

function renderDepartment() {
	table = $('#dtb_dept').DataTable( {
			"processing": true,
			"pagingType": "full_numbers",
			"searching": true,
			"sDom": '<\'row\'<\'col-sm-2\'f>><\'row\'<\'col-sm-12\'t>><\'row\'<\'col-sm-6\'l><\'col-sm-6\'p>>',
			"oLanguage": {
				"sLengthMenu": "แสดง_MENU_รายการ",
				"sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
				"sSearch" : "Apply filter _INPUT_ to table"
			},
			"ajax": {
				url: "/rmuti-electronicqueue/Department/getDepartment",
				dataSrc: ""
			},
			"columns": [
				{ "data": "id" },
				{ "data":"dept_name" },
				{ "data":"status" },
				{
					data: "id",
					className: "center",
					render: function(data){
						return	'<button type="button" class="btn btn-primary btn-rounded btn-sm my-0" onclick="show_modalDept('+ parseInt(data) +')">แก้ไข</button>' +
								'<button type="button" class="btn btn-danger btn-rounded btn-sm my-0" onclick="deleteDept('+ parseInt(data) +')">ลบ</button>'
					}
				}
			]
		} );

	$('#dtb_dept_wrapper').find('label').each(function () {
		$(this).parent().append($(this).children());
	});
	$('#dtb_dept_wrapper .dataTables_filter').find('input').each(function () {
		const $this = $(this);
		$this.attr("placeholder", "Search");
		$this.removeClass('form-control-sm');
	});
	$('#dtb_dept_wrapper .dataTables_filter').addClass('md-form');
	$('#dtb_dept_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
	$('#dtb_dept_wrapper select').addClass('custom-select-dtb');
	$('#dtb_dept_wrapper .dataTables_filter').find('label').remove();
	$('#dtb_dept_filter').removeClass('dataTables_filter ');
	$('#dtb_dept_filter').children('input').prop('placeholder', "ค้นหา");
	$('#dtb_dept').parent('div .col-sm-12').addClass('table-responsive');
}

function deleteDept(id) {
	Swal.fire({
		title: 'ยืนยันการลบ',
		text: "คุณต้องการลบแผนกงานหมายเลข "+ id.toString().padStart(2, "0") +" ?" ,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ตกลง',
		cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url : "/rmuti-electronicqueue/Department/deleteDept/" + id,
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
						text: "ไม่สามารถลบแผนกงานหมายเลข "+ id.toString().padStart(2, "0") +" ได้" ,
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

