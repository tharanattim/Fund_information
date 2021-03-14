var validat;
var service;
var timer;

$(function () {
	$('#loading-page').show();
	$.when(
		resizeFooter(),
		renderUserType(),
		renderDepartment(),
		getService(),
		$(".select-simple").select2({
			theme: "bootstrap",
			minimumResultsForSearch: Infinity,
		}),
		validation(),
		validationcheck_queue()
	).done(function () {
		$('#loading-page').hide();
	});

	$('#dark-mode').on('click', function (e) {
		changeDarkMode();
	});

	$('#btn_reset').click(function() {
		$('#form_booking')[0].reset();
		$('#form_booking').removeClass('was-validated');
		$('#remember_phone').prop("checked",false);
		$('#select2-usertype-container').text('เลือกประเภทผู้ใช้งาน');
		$('#select2-department-container').text('เลือกแผนกงาน');
		$('#select2-service-container').text('เลือกรายการที่ใช้ติดต่อ');
		if($('#dark-mode').is(":checked")){
			$('.mdb-select.select-wrapper .select-dropdown').addClass('dark-card-admin');
		}else if($('#dark-mode').is(":not(:checked)")){
			$('.mdb-select.select-wrapper .select-dropdown').removeClass('dark-card-admin');
		}
	});

	$(window).resize(function() {
		resizeFooter();
	});

	$('#department').change(function() { //เมื่อมีการเลือก department
		renderService($(this).val()); //ส่งค่า id ของ department เพื่อไปหา Service
	});

	$('#btn_cancel').click(function() {
		window.clearTimeout(timer);
		$('#modal_booking').modal('hide');
	});

	$('.select2-selection__rendered').hover(function () {
		$(this).removeAttr('title');
	});
})

function changeDarkMode() {
	$('h4, button').not('.check').toggleClass('dark-grey-text text-white');
	$('.list-panel a').toggleClass('dark-grey-text');
	$('footer, .card').toggleClass('dark-card-admin');
	$('body, .navbar').toggleClass('white-skin navy-blue-skin');
	$(this).toggleClass('white text-dark btn-outline-black');
	$('body').toggleClass('dark-bg-admin');
	$('h6, .card, p, td, th, i, li a, h4, input, label').not('#slide-out i, #slide-out a, .dropdown-item i, .dropdown-item').toggleClass('text-white');
	$('.btn-dash').toggleClass('grey blue').toggleClass('lighten-3 darken-3');
	$('.gradient-card-header').toggleClass('white black lighten-4');
	$('.list-panel a').toggleClass('navy-blue-bg-a text-white').toggleClass('list-group-border');
	$('.mdb-select.select-wrapper .select-dropdown').toggleClass('dark-card-admin');
}

function validation() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#btn_booking').click(function() {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
				validat = false;
			}else {
				var dept_id = $('#department option:selected').val();
				if (checkSystemStatus(dept_id)){
					bookingQueue();
				}else {
					Swal.fire({
						title: 'ไม่สามารถจองคิวได้',
						text: "แผนกงานนี้ยังไม่เปิดให้บริการในขณะนี้",
						icon: 'warning'
					});
				}
			}
			form.classList.add('was-validated');
		});
	});
}

function resizeFooter() {
	if($( window ).height()>1157){
		$('footer').addClass('fixed-bottom');
	}else {
		$('footer').removeClass('fixed-bottom');
	}
}

function bookingQueue() {
	if (checkDupQueue()){ //ไม่มีคิว
		$.ajax({
			url : "/rmuti-electronicqueue/Booking/getQueueByDeptAndDate/" + $('#department option:selected').val() + "/" + getDate() , //ตรวจสอบคิวของแผนกงานนี้ในวันนี้ในคิวที่สถานะเป็นรอและกำลังใช้งาน
			type : 'GET',
			async : false
		}).done(function(data) {
			var result = JSON.parse(data); // คิวของแผนกงานนี้
			var count_queue = 0; // คิวทั้งหมดที่รอและกำลังใช้งาน
			var curent_queue = ""; //คิวปัจจุบันเริ่มต้นคือ ว่าง
			var wating_time = 0; //คิวแรก wating_time = 0
			var your_queue; // คิวของคุณที่จะทำการจอง
			var max_queue = 0; //ลำดับคิวล่าสุดที่กำลังรอคิวอยู่

			switch ($('#department option:selected').val()) { // switch ตรวจสอบได้แค่ ตัวเลขและตัวอักษร ต่างจาก if
				case '01' : your_queue = 'A'; break;
				case '02' : your_queue = 'B'; break;
				case '03' : your_queue = 'C'; break;
			}

			if (result.length != 0){
				if (result[0].dept_status == '03') {
					wating_time += parseInt(result[0].pause_time);
				}
			}

			$.each(result, function (i, v) {
				if (v.status == '02'){	//คิวใดที่มีสถานะ 02 กำลังใช้งาน
					curent_queue = v.queue_no; //คิวปัจจุบัน = queue_no
				}
				if (v.status == '01' || v.status == '02'){
					wating_time += parseInt(v.service_time); //เวลารอทั้งหมดที่อยู่ในแผนกงานนี้  parseInt คือ ทำให้เป็น int เพราะตอนนี้เวลาเป็น String
					count_queue += 1;
				}
				if (parseInt(result[i].queue_no.substr(1)) > max_queue){
					max_queue = parseInt(result[i].queue_no.substr(1));
				}
			});

			$('#lbl_curent_queue').text((curent_queue == "" ? '' : curent_queue)); // ถ้า count_queue = "" ให้แสดง  ใน lbl_curent_queue
			$('#lbl_your_queue').text(your_queue + (max_queue + 1).toString().padStart(3, "0")); //max_queue ทั้งหมด +1 ก็จะได้คิวของคุณ และแปลงให้แปลง toString, padStart(3, "0") กำหนด 0 ให้3ตัว เช่น A000 ตัวข้างหน้าจะแยกแผนกงาน
			$('#lbl_count_queue').text((count_queue == 0 ? '0' : count_queue)); //คิวที่รอถ้าไม่มีคิว result.length = 0 ให้แสดง 0 แต่ถ้ามีคิวที่รอก็ให้แสดงจำนวนคิว result.length
			$('#lbl_waiting_time').text(wating_time + " นาที"); //เวลาที่รอทั้งหมดของทุกคิว +นาที

			timer = setTimeout(bookingQueue, 850);

			$('#modal_booking').modal('show'); //ทำ function ข้างบนเสร็จค่อยให้แสดง modal
		}).fail(function() {
			Swal.fire({
				title: 'ระบบผิดพลาด',
				text: "ไม่สามารถดำเนินการได้ในขณะนี้",
				icon: 'error'
			});
		});

	}else { //คิวซ้ำหรือมีคิวอยู่แล้ว
		$('#modal_booking').modal('hide');
		Swal.fire({
			title: 'ท่านได้ทำการจองคิวแล้ว',
			text: "กรุณาใช้เมนูตรวจสอบคิว เพื่อตรวจสอบคิวของท่าน",
			icon: 'warning'
		});
	}
}

function confirm_booking() {
	window.clearTimeout(timer);
	var data = { //JavaScript Object
		"queue_no" : $('#lbl_your_queue').text().trim(), //trim ตัดช่องว่างหัวท้าย
		"user_type" : $('#usertype option:selected').val(),
		"phone_number" : $('#phonenumber').val().trim(),
		"service" : $('#service option:selected').val(),
		"department" : $('#department option:selected').val(),
		"status" : "01", //status gibj,9hogxHo 01 รอ
		"waiting_time" : parseInt($('#lbl_waiting_time').text().trim())
	}

	$.ajax({
		url : "/rmuti-electronicqueue/Booking/postBookingQueue", //ยิงไป save
		type : 'POST',
		data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
		contentType: "application/json; charset=utf-8",
		async : false
	}).done(function(data) { //POST สำเร็จ return เป็นจริง
		var result = JSON.parse(data);
		if (result){
			$('#modal_booking').modal('hide');
			checkQueue();
		}
	}).fail(function() {
		$('#modal_booking').modal('hide');
		Swal.fire({
			title: 'ระบบผิดพลาด',
			text: "ไม่สามารถดำเนินการได้ในขณะนี้",
			icon: 'error'
		});
	});
}

function validationcheck_queue() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#btn_check_queue').click(function() {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
				validat = false;
			}else {
				if (!checkDupQueue()){ //ถ้าจองคิวแล้ว
					checkQueue();
				}else { //ถ้ายังไม่ได้จองคิว
					Swal.fire({
						title: 'ไม่พบคิวของท่าน',
						text: "กรุณาใช้เมนูจองคิว เพื่อจองคิวของท่าน",
						icon: 'warning'
					});
				}
			}
			form.classList.add('was-validated');
		});
	});
}

function renderUserType() {
	$.ajax({
		url : "/rmuti-electronicqueue/Booking/getUserType", //ยิงไปขอข้อมูล contro booking med getUserType
		type : 'GET',
		async : false	//โหลดข้อมูลให้เสร็จแล้วให้ทำต่อไป
	}).done(function(data) {	// ขอข้อมูลสำเร็จ
		var result = JSON.parse(data);	 //แปลง JSON ให้เป็น object แล้วเก็บไว้ใน result
		$.each(result, function (i, v) {	// นำresult each index,value
			$('#usertype').append('<option value=' + v.id  + '>' + v.type_name + '</option>'); //ส่งค่าid แต่แสดง type_name append ลง #usertype
		});
	}).fail(function() {
	});
}

function renderDepartment() {
	$.ajax({
		url : "/rmuti-electronicqueue/Booking/getDepartment", //contro booking med getDepartment
		type : 'GET',
		async : false	//โหลดข้อมูลให้เสร็จแล้วให้ทำต่อไป
	}).done(function(data) {	// ขอข้อมูลสำเร็จ
		var result = JSON.parse(data);	 //แปลง JSON ให้เป็น object แล้วเก็บไว้ใน result
		$.each(result, function (i, v) { 	// นำresult each index,value
			$('#department').append('<option value=' + v.id  + '>' + v.dept_name + '</option>'); //ส่งค่าid แต่แสดง dept_name append ลง #department
		});
	}).fail(function() {
	});
}

function renderService(id) {
	$('#service').empty(); //ทำ service ให้มันว่าง
	$('#service').append('<option value="" disabled selected>เลือกรายการที่ใช้ติดต่อ</option>');
	$('#select2-service-container').text('เลือกรายการที่ใช้ติดต่อ');
	$.each(service, function (i, v) {
		if (v.department == id){
			$('#service').append('<option value=' + v.id  + '>' + v.service_name + '</option>');
		}
	});
}

function getService() { //ยิงไปขอข้อมูลมาไว้ก่อน
	$.ajax({
		url : "/rmuti-electronicqueue/Booking/getService", //contro booking med getService
		type : 'GET',
		async : true // ไม่ต้องรอให้getService ทำงานเสร็จ function ต่อไปก็สามารถทำงานไปได้เลย
	}).done(function(data) {
		service = JSON.parse(data); // getService ทั้งหมดออกมาเก็บไว้ในตัวแปร service
	}).fail(function() {
	});
}

function getDate() {
	var date = new Date();
	var month = date.getMonth()+1;
	var day = date.getDate();
	return date.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;
}

function cancelQueue() {
	Swal.fire({
		title: 'ยกเลิกคิว',
		text: "ท่านต้องการยกเลิกคิวหรือไม่ ?",
		icon: 'warning',
		cancelButtonColor: '#d33',
		confirmButtonColor: '#218838',
		showCancelButton: true,
		confirmButtonText: 'ตกลง',
		cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		if (result.value) {
			window.clearTimeout(timer);
			data = {
				'status' : '3'
			}
			$.ajax({
				url : "/rmuti-electronicqueue/Booking/updateBookingQueue/" + $('#lbl_your_queue').data( "id") ,
				type : 'PUT',
				data : JSON.stringify(data),
				contentType: "application/json; charset=utf-8",
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				if (result){
					decreaseTime($('#lbl_your_queue').data("id"), $('#lbl_s_department').data("dept"), $('#lbl_s_service').data("time"));
					Swal.fire({
						title: 'ยกเลิกคิวสำเร็จ',
						icon: 'success',
					}).then((result) => {
						if (result.value) {
							window.location.href = base_url+"Booking";
						}
					});
				}
			}).fail(function() {
				Swal.fire({
					title: 'ระบบผิดพลาด',
					text: "ไม่สามารถดำเนินการได้ในขณะนี้",
					icon: 'error'
				}).then((result) => {
					if (result.value) {
						window.location.href = base_url+"Booking";
					}
				});
			});
		}
	});
}

function checkQueue() {
	$.ajax({
		url : "/rmuti-electronicqueue/Booking/getQueueByPhoneNumberAndDate/" + $('#phonenumber').val().trim() + "/" + getDate(),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result_your_queue = JSON.parse(data);
		var your_queue = null;
		var queue_status  = null;
		var department = null;
		var waiting_time = null;
		var dept_name = null;
		var service_name = null;

		$.each(result_your_queue, function (i, v) {
			if (v.status == '01' || v.status == '02'){
				$('#lbl_your_queue').data( "id", parseInt(v.id) );
				$('#lbl_s_department').data( "dept", v.department);
				$('#lbl_s_service').data( "time", v.time);
				your_queue = v.queue_no;
				queue_status = v.status;
				department = v.department;
				waiting_time = v.waiting_time;
				dept_name = v.dept_name;
				service_name = v.service_name;
			}else {
				queue_status = v.status;
			}

			if (v.status == '02') {
				$('#btn_cancel_queue').prop('disabled', true);
			}else {
				$('#btn_cancel_queue').prop('disabled', false);
			}
		});

		if (queue_status == '01' || queue_status == '02' ){
			$.ajax({
				url : "/rmuti-electronicqueue/Booking/getQueueByDeptAndDate/" + department + "/" + getDate(),
				type : 'GET',
				async : false
			}).done(function(data) {
				var result_all_queue = JSON.parse(data);
				var count_queue = 0;
				var curent_queue = null;
				var my_queue = parseInt(your_queue.substr(1));

				$.each(result_all_queue, function (i, v) {
					if (v.status == '02'){
						curent_queue = v.queue_no;
					}
					if (v.status == '01' || v.status == '02'){
						if (parseInt(v.queue_no.substr(1)) < my_queue){
							count_queue++;
						}
					}
				});

				$('#lbl_s_curent_queue').text(( curent_queue == null ? '' : curent_queue));
				$('#lbl_s_your_queue').text((your_queue == null ? '' : your_queue));
				$('#lbl_s_count_queue').text((curent_queue == your_queue ? '0' : count_queue)); //นับสถานะแค่ 01-02 ไม่นับ 02 ของตัวเอง
				$('#lbl_s_waiting_time').text(waiting_time + " นาที");
				$('#lbl_s_department').text(dept_name);
				$('#lbl_s_service').text(service_name)
				if ($('#lbl_s_curent_queue').text() == $('#lbl_s_your_queue').text()){
					$('#lbl_your_queue_anima').css('display', 'inline-block');
				}else {
					$('#lbl_your_queue_anima').css('display', 'none');
				}

				timer = setTimeout(checkQueue, 1500);

			}).fail(function() {
			});
			$('#modal_confirm').modal('show');
		}else {
			if (queue_status == '04'){
				window.clearTimeout(timer);
				Swal.fire({
					title: 'ยกเลิกคิว',
					text: "คิวของท่านถูกยกเลิกโดยเจ้าหน้าที่",
					icon: 'error'
				}).then((result) => {
					if (result.value) {
						window.location.href = base_url+"Booking";
					}
				});
			}else  if (queue_status == '05'){
				window.clearTimeout(timer);
				Swal.fire({
					title: 'เสร็จสิ้น',
					text: "รายการของท่านเสร็จสิ้นแล้ว",
					icon: 'success'
				}).then((result) => {
					if (result.value) {
						window.location.href = base_url+"Booking";
					}
				});
			}
		}
	}).fail(function() {
	});
}

function checkDupQueue() { //ตรวจสอบคิวของเบอร์นี้ที่มีอยู่
	var countQueue = 0;
	$.ajax({
		url : "/rmuti-electronicqueue/Booking/getQueueByPhoneNumberAndDate/" + $('#phonenumber').val().trim() + "/" + getDate(),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data)
		$.each(result, function (i, v) {
			if (v.status == '01' || v.status == '02'){
				countQueue++;
			}
		});
	}).fail(function() {
	});
	if (countQueue > 0){
		return false;
	}else {
		return true;
	}
}

function checkSystemStatus(dept_id){
	var status = false;
	$.ajax({
		url : "/rmuti-electronicqueue/Department/getStaustByid/" + dept_id,
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data)
		if (result[0].status == '01' || result[0].status == '03'){
			status = true;
		}
	}).fail(function() {
	});
	if (status){
		return true;
	}else {
		return false;
	}
}

function decreaseTime(queueId, dept, time){
	$.ajax({
		url : `/rmuti-electronicqueue/Queue/getAllQueueByDeptAndDate/${dept}/${moment().format("YYYY-MM-DD")}`,
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			$.each(result, function (i, v) {
				if (v.id > queueId) {
					var data = {
						'waiting_time' : parseInt(v.waiting_time) - parseInt(time)
					}
					$.ajax({
						url : "/rmuti-electronicqueue/Booking/updateBookingQueue/" + v.id ,
						type : 'PUT',
						data : JSON.stringify(data),
						contentType: "application/json; charset=utf-8",
						async : false
					}).done(function(data) {
					}).fail(function() {
					});
				}
			});
		}
	}).fail(function() {
	});
}
