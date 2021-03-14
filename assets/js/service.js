var validat;
var table;

$(function () {
	$('#loading-page').show();
	$.when(
		loadSideNav(),
		renderService(),
		initSelect(),
		btnAddAnima(),
		validation_service()
	).done(function () {
		$('#loading-page').hide();
	});
})

function initSelect() {
	$('#select_dept .mdb-select').materialSelect();
	$('#select_dept .mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder", "เลือกเวลาที่ต้องการ").prop('required', true).addClass('form-control').css('background-color', '#fff');
}

function loadSideNav() {
	$("#btn_sideNav").sideNav();
}

function btnAddAnima() {
	$('#btn_add')
		.mouseover(function () {
			$('#btn_add').addClass('animated heartBeat infinite');
		})
		.mouseout(function () {
			$('#btn_add').removeClass('animated heartBeat infinite');
		});
}

function resetModal() {
	$('#lbl_modal').html('เพิ่มรายการติดต่อ');
	$('#id').prop('disabled',false);
	$('#id').val('');
	$('#name').val('');
	setTimeout(function() {
		$("#name").focus();
	}, 500);
	$('#time').val('');
	$('#form_service').removeClass('was-validated');
	$('#modal_service').modal('hide');
}

function show_modalService(id) {
	if(id == ''){
		$.ajax({
			url : "/rmuti-electronicqueue/Service/getIDservice",
			type : 'GET',
			async : false
		}).done(function(data) {
			$('#form_service').removeClass('was-validated');
			var result = JSON.parse(data);
			$('#lbl_modal').html('เพิ่มรายการติดต่อ');
			$('#id').val(result[0].id != null ? (parseInt(result[0].id) + 1).toString().padStart(3, "0") : '001');
			$('#id').prop('disabled',true);
			$('#name').val('');
			$('#time').val('');

			$.ajax({
				url : "/rmuti-electronicqueue/Service/getDepartment",
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				$('#department').empty();
				$.each(result, function (i, v) {
					$('#department').append('<option value=' + v.id  + '>' + v.dept_name + '</option>');
				});

				setTimeout(function(){
					$('input.select-dropdown.form-control').addClass('text-left');
					$('#select_dept .mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder", "เลือกแผนกงาน").prop('required', true).addClass('form-control').css('background-color', '#fff');
				}, 100);
				setTimeout(function(){
					$("#name").focus();
				}, 500);
				$('#modal_service').modal('show');

			}).fail(function() {
				resetModal();
				Swal.fire({
					title: 'ระบบผิดพลาด',
					text: "ไม่สามารถดำเนินการได้ในขณะนี้",
					icon: 'error'
				})
			});

		}).fail(function() {
			resetModal();
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			})
		});
	}else {
		$('#form_service').removeClass('was-validated');
		$.ajax({
			url : "/rmuti-electronicqueue/Service/getServiceByid/" + id,
			type : 'GET',
			async : false
		}).done(function(data) {
			var result = JSON.parse(data);
			var department = result[0].department;
			$('#id').val(result[0].id);
			$('#name').val(result[0].service_name);
			$('#time').val(result[0].time);
			$('#lbl_modal').html('แก้ไขรายการติดต่อ');
			$('#id').prop('disabled',true);

			$.ajax({
				url : "/rmuti-electronicqueue/Service/getDepartment",
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				$('#department').empty();
				$.each(result, function (i, v) {
					$('#department').append('<option value=' + v.id  + '>' + v.dept_name + '</option>');
				});

				setTimeout(function(){
					$('#department').val(department);
					$('input.select-dropdown.form-control').addClass('text-left');
					$('#select_dept .mdb-select.select-wrapper .select-dropdown').val($('#department option:selected').text()).removeAttr('readonly').attr("placeholder", "เลือกแผนกงาน").prop('required', true).addClass('form-control').css('background-color', '#fff');
				}, 100);
				setTimeout(function(){
					$("#name").focus();
				}, 500);
				$('#modal_service').modal('show');

			}).fail(function() {
				resetModal();
				Swal.fire({
					title: 'ระบบผิดพลาด',
					text: "ไม่สามารถดำเนินการได้ในขณะนี้",
					icon: 'error'
				})
			});

		}).fail(function() {
		});
	}
}

function validation_service() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#btn_save_service').click(function() {
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
	if ($('#lbl_modal').html() == 'เพิ่มรายการติดต่อ') {
		var data = {
			"id" : $('#id').val(),
			"service_name" : $('#name').val(),
			"time" : $('#time').val(),
			"department" : $('#department option:selected').val()
		}

		$.ajax({
			url : "/rmuti-electronicqueue/Service/saveService",
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

	}else {//update
		var data = {
			"service_name" : $('#name').val(),
			"time" : $('#time').val(),
			"department" : $('#department option:selected').val()
		}

		$.ajax({
			url : "/rmuti-electronicqueue/Service/updateService/" + $('#id').val(),
			type : 'PUT',
			data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
			contentType: "application/json; charset=utf-8",
			async : false
		}).done(function(data) { //PUT สำเร็จ return เป็นจริง
			var result = JSON.parse(data);
			if (result){
				table.ajax.reload(null, false);
				$('#form_service')[0].reset();
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

function renderService() {
	table = $('#dtb_service').DataTable( {
			"processing": true,
			"pagingType": "full_numbers",
			"searching": true,
			"sDom": '<\'row\'<\'col-sm-2\'f>><\'row\'<\'col-sm-12\'t>><\'row\'<\'col-sm-6\'l><\'col-sm-6\'p>>',
			"oLanguage": {
				"sLengthMenu": "แสดง_MENU_รายการ",
				"sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ"
			},
			"ajax": {
				url: "/rmuti-electronicqueue/Service/getService",
				dataSrc: ""
			},
			"columns": [
				{ "data": "id" },
				{ "data":"service_name" },
				{ "data":"time" },
				{ "data":"dept_name" },
				{
					data: "id",
					className: "center",
					render: function(data){
						return '<button type="button" class="btn btn-primary btn-rounded btn-sm my-0" onclick="show_modalService('+ parseInt(data) +')">แก้ไข</button>' +
							'<button type="button" class="btn btn-danger btn-rounded btn-sm my-0" onclick="deleteService('+ parseInt(data) +')">ลบ</button>'
					}
				}
			]
		} );

	$('#dtb_service_wrapper').find('label').each(function () {
		$(this).parent().append($(this).children());
	});
	$('#dtb_service_wrapper .dataTables_filter').find('input').each(function () {
		const $this = $(this);
		$this.attr("placeholder", "Search");
		$this.removeClass('form-control-sm');
	});
	$('#dtb_service_wrapper .dataTables_filter').addClass('md-form');
	$('#dtb_service_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
	$('#dtb_service_wrapper select').addClass('custom-select-dtb');
	$('#dtb_service_wrapper .dataTables_filter').find('label').remove();
	$('#dtb_service_filter').removeClass('dataTables_filter ');
	$('#dtb_service_filter').children('input').prop('placeholder', "ค้นหา");
	$('#dtb_service').parent('div .col-sm-12').addClass('table-responsive');
}

function deleteService(id) {
	Swal.fire({
		title: 'ยืนยันการลบ',
		text: "คุณต้องการลบรายการติดต่อหมายเลข "+ id.toString().padStart(3, "0") +" ?" ,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ตกลง',
		cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url : "/rmuti-electronicqueue/Service/deleteService/" + id,
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
						text: "ไม่สามารถลบรายการติดต่อหมายเลข "+ id.toString().padStart(3, "0") +" ได้" ,
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
