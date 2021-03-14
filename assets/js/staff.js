var validat;
var table;
var myDropzone;
var proFiles = null;
var profilesName = null;

$(function () {
	$('#loading-page').show();
	$.when(
		loadSideNav(),
		renderStafff(),
		initSelect(),
		btnAddAnima(),
		validation_staff(),
		initDropzone()
	).done(function () {
		$('#loading-page').hide();
	});

})

Dropzone.options.profile = {
	addRemoveLinks: true,
	dictRemoveFile: '<div>ลบรูปโปรไฟล์ <i class="fad fa-trash-alt"></i></div>', //ปุ่มลบรูปโปรไฟล์
	acceptedFiles: 'image/*',
	maxFilesize: 1, //ขนาดไฟล์ ไม่เกิน 1 MB
	maxFiles:1,	// จำนวนไฟล์ ไม่เกิน 1 ไฟล์
	init: function() {

		myDropzone = this;

		this.on("complete", function() { //ถ้าตัวมันเอง อัพโหลดรูป สำเร็จ
			if (myDropzone.files[0] != undefined){ // และถ้ามีรูปในตำแหน่งที่ 0 จริง
				if (profilesName != null){ // กรณี แก้ไข -->
					$('img[alt="'+ profilesName +'"]').parents('div .dz-preview').remove(); //เเราจะไปเลือก remove ที่ .dz-preview เลือกที่แท็ก img ที่มีแอตทริบิวและก็ชื่อไฟล์ ก่อนหน้านี้มีันจะมีไฟล์อยู่แล้ว
				}
				proFiles = myDropzone.files[0].xhr.responseText.split('"').join('').trim();
			}
		});

		this.on("maxfilesexceeded", function(file) { // function maxfilesexceeded อัพโหลดเกินที่กำหนดไว้
			this.removeAllFiles(); // มันก็จะ removeAllFiles ออกไป
			this.addFile(file); // มันจะ addFile ลงไปใหม่
		});

		this.on("error", function(file, message) { // function error
			if (message.includes("File is too big")){ //ถ้า file มันใหญ่เกินกำหนด และถ้ามีคำว่า File is too big ใน error message //includes คือ หาคำเหมือน ใน function error ที่เขาเขียนไว้
				Swal.fire({
					title: 'ไม่สามารถอัพโหลดได้',
					text: "กรุณาอัพโหลดไฟล์ขนาดไม่เกิน 1 MB",
					icon: 'warning'
				})
				this.removeFile(file);
			}
		});
	}
};

function initDropzone() {
	$('.dz-button').text('คลิกหรือลากรูปโปรไฟล์ของคุณมาวางที่นี่');
}

function initSelect() {
	$('#select_dept .mdb-select').materialSelect();
	$('#select_dept .mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder", "เลือกแผนกงาน").prop('required', true).addClass('form-control').css('background-color', '#fff');
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
	myDropzone.removeAllFiles(true);
	$('.dz-preview').remove();
	$('#lbl_modal').html('เพิ่มเจ้าหน้าที่');
	$('#id').prop('disabled',false);
	$('#id').val('');
	setTimeout(function() {
		$("#name").focus();
	}, 500);
	$('#fname').val('');
	$('#lname').val('');
	$('#pos').val('');
	$('#username').val('');
	$('#password').val('');
	$('#dept').val('');
	$('#form_staff').removeClass('was-validated');
	$('#modal_staff').modal('hide');
}

function show_modalStaff(id) {
	if(id == ''){
		$.ajax({
			url : "/rmuti-electronicqueue/Staff/getIDStaff",
			type : 'GET',
			async : false
		}).done(function(data) {
			$('#form_staff').removeClass('was-validated');
			var result = JSON.parse(data);
			$('#lbl_modal').html('เพิ่มเจ้าหน้าที่');
			$('#id').val(result[0].id != null ? (parseInt(result[0].id) + 1).toString().padStart(3, "0") : '001');
			$('#id').prop('disabled',true);
			$('#fname').val('');
			setTimeout(function() {
				$("#fname").focus();
			}, 500);
			$('#lname').val('');
			$('#pos').val('');
			$('#dept').val('');
			$('#username').val('');
			$('#password').val('');

			$.ajax({
				url : "/rmuti-electronicqueue/Staff/getDepartment",
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				$('#department').empty();
				$.each(result, function (i, v) {
					$('#department').append('<option value=' + v.id + '>' + v.dept_name + '</option>');
				});

				setTimeout(function () {
					$('input.select-dropdown.form-control').addClass('text-left');
					$('#select_dept .mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder", "เลือกแผนกงาน").prop('required', true).addClass('form-control').css('background-color', '#fff');
				}, 100);
				setTimeout(function () {
					$("#fname").focus();
				}, 500);
				$('#modal_staff').modal('show');

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
		$('#form_staff').removeClass('was-validated');
		$.ajax({
			url : "/rmuti-electronicqueue/Staff/getStaffByid/" + id,
			type : 'GET',
			async : false
		}).done(function(data) {
			var result = JSON.parse(data);
			var department = result[0].department;
			profilesName = result[0].profile;
			$('#id').val(result[0].id);
			$('#fname').val(result[0].fname);
			$('#lname').val(result[0].lname);
			$('#pos').val(result[0].position);
			$('#username').val(result[0].username);
			$('#lbl_modal').html('แก้ไขเจ้าหน้าที่');
			$('#id').prop('disabled',true);

			$.ajax({
				url : "/rmuti-electronicqueue/Staff/getDepartment",
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				$('#department').empty();
				$.each(result, function (i, v) {
					$('#department').append('<option value=' + v.id + '>' + v.dept_name + '</option>');
				});

				setTimeout(function () {
					$('#department').val(department);
					$('input.select-dropdown.form-control').addClass('text-left');
					$('#select_dept .mdb-select.select-wrapper .select-dropdown').val($('#department option:selected').text()).removeAttr('readonly').attr("placeholder", "เลือกแผนกงาน").prop('required', true).addClass('form-control').css('background-color', '#fff');
				}, 100);
				setTimeout(function () {
					$("#fname").focus();
				}, 500);

				if (profilesName != null){
					var mockFile = {
						name: profilesName,
						size: 12345
					};

					myDropzone.removeAllFiles(true);
					$('.dz-preview').remove();
					myDropzone.emit("addedfile", mockFile);
					myDropzone.emit("thumbnail", mockFile, "assets/images/profiles/" + profilesName);
					myDropzone.emit("complete", mockFile);
					$('img[data-dz-thumbnail]').css('width','-webkit-fill-available');
				}

				$('#modal_staff').modal('show');

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

function validation_staff() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#btn_save_staff').click(function() {
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
	if ($('#lbl_modal').html() == 'เพิ่มเจ้าหน้าที่') {
		var data = {
			"id" : $('#id').val(),
			"fname" : $('#fname').val(),
			"lname" : $('#lname').val(),
			"position" : $('#pos').val(),
			"username" : $('#username').val(),
			"password" : $('#password').val(),
			"rloe" : "staff",
			"profile" :  $('div .dz-preview').length > 0 ? proFiles : null ,
			"department" : $('#department option:selected').val()
		}

		$.ajax({
			url : "/rmuti-electronicqueue/Staff/saveStaff",
			type : 'POST',
			data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
			contentType: "application/json; charset=utf-8",
			async : false
		}).done(function(data) { //POST สำเร็จ return เป็นจริง
			var result = JSON.parse(data);
			if (result){
				$.get( "/rmuti-electronicqueue/Staff/delProfiles", function() {
					table.ajax.reload(null, false);
					resetModal();
					Swal.fire({
						title: 'เพิ่มข้อมูลสำเร็จ',
						icon: 'success',
						timer: 1000
					})
				})
			}else{
				table.ajax.reload(null, false);
				resetModal();
				Swal.fire({
					title: 'ไม่สามารถเพิ่มข้อมูลได้',
					text: "ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว",
					icon: 'error'
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
			"fname" : $('#fname').val(),
			"lname" : $('#lname').val(),
			"position" : $('#pos').val(),
			"username" : $('#username').val(),
			"password" : $('#password').val(),
			"rloe" : "staff",
			"profile" : ($('div .dz-preview').length > 0) && (proFiles != null) ? proFiles : null ,
			"department" : $('#department option:selected').val( )
		}

		$.ajax({
			url : "/rmuti-electronicqueue/Staff/updateStaff/" + $('#id').val(),
			type : 'POST',
			data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
			contentType: "application/json; charset=utf-8",
			async : false
		}).done(function(data) { //POST สำเร็จ return เป็นจริง
			var result = JSON.parse(data);
			if (result){
				$.get( "/rmuti-electronicqueue/Staff/delProfiles", function() {
					table.ajax.reload(null, false);
					resetModal();
					Swal.fire({
						title: 'แก้ไขข้อมูลสำเร็จ',
						icon: 'success',
						timer: 1000
					})
				})
			}else{
				table.ajax.reload(null, false);
				resetModal();
				Swal.fire({
					title: 'ไม่สามารถแก้ไขข้อมูลได้',
					text: "ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว",
					icon: 'error'
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

function renderStafff() {
	table = $('#dtb_staff').DataTable( {
			"processing": true,
			"pagingType": "full_numbers",
			"searching": true,
			"sDom": '<\'row\'<\'col-sm-2\'f>><\'row\'<\'col-sm-12\'t>><\'row\'<\'col-sm-6\'l><\'col-sm-6\'p>>',
			"oLanguage": {
				"sLengthMenu": "แสดง_MENU_รายการ",
				"sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ"
			},
			"ajax": {
				url: "/rmuti-electronicqueue/Staff/getStaffNoneAdmin",
				dataSrc: ""
			},
			"columns": [
				{ "data": "id" },
				{ "data":"fname" },
				{ "data":"lname" },
				{ "data":"position" },
				{ "data":"username" },
				{ "data":"dept_name" },
				{
					data: "id",
					className: "center",
					render: function(data){
						return	'<button type="button" class="btn btn-primary btn-rounded btn-sm my-0" onclick="show_modalStaff('+ parseInt(data) +')">แก้ไข</button>' +
								'<button type="button" class="btn btn-danger btn-rounded btn-sm my-0" onclick="deleteStaff('+ parseInt(data) +')">ลบ</button>'
					}
				}
			]
		} );

	$('#dtb_staff_wrapper').find('label').each(function () {
		$(this).parent().append($(this).children());
	});
	$('#dtb_staff_wrapper .dataTables_filter').find('input').each(function () {
		const $this = $(this);
		$this.attr("placeholder", "Search");
		$this.removeClass('form-control-sm');
	});
	$('#dtb_staff_wrapper .dataTables_filter').addClass('md-form');
	$('#dtb_staff_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
	$('#dtb_staff_wrapper select').addClass('custom-select-dtb');
	$('#dtb_staff_wrapper .dataTables_filter').find('label').remove();
	$('#dtb_staff_filter').removeClass('dataTables_filter ');
	$('#dtb_staff_filter').children('input').prop('placeholder', "ค้นหา");
	$('#dtb_staff').parent('div .col-sm-12').addClass('table-responsive');
}

function deleteStaff(id) {
	Swal.fire({
		title: 'ยืนยันการลบ',
		text: "คุณต้องการลบเจ้าหน้าที่หมายเลข "+ id.toString().padStart(3, "0") +" ?" ,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ตกลง',
		cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url : "/rmuti-electronicqueue/Staff/deleteStaff/" + id,
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
						text: "ไม่สามารถลบเจ้าหน้าที่หมายเลข "+ id.toString().padStart(3, "0") +" ได้" ,
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
