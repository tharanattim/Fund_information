var table;
var successTime;
var arrivalTime;
var serviceTime;
var beforeTime;
var currentQueue = null;

$(function () {
	$('#loading-page').show();
	$.when(
		loadSideNav(),
		renderStatus(),
		loadTable(),
		loadTimepicker(),
		statusAnima(),
		resizeLabel(),
		rederQueue(),
		timeNow(),
		initSelect(),
		validation_pause()
	).done(function () {
		$('#loading-page').hide();
	});

	$( window ).resize(function() {
		resizeLabel();
	});

	$("#dept_regis_status").change(function() {
		if(this.checked) {
			updateSystemStatus('01');
		}else {
			updateSystemStatus('02');
		}
	});

	$('#btn_cancel_pause').click(function(){
		$('#form_pause').removeClass('was-validated');
		$('#select_time > div > input').val('');
	});
})

function initSelect() {
	$('#select_time .mdb-select').materialSelect();
	$('#select_time .mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder", "เลือกเวลาที่ต้องการ").prop('required', true).addClass('form-control').css('background-color', '#fff');
}

function loadTimepicker() {
	$('#success_time').pickatime({
		'default': 'now',
		afterDone: function () {
			if ($('#lbl_queue_no').text() != "-"){
				var  afretTime = $('#success_time').val();
				var diff = diffTime(beforeTime, afretTime);
				serviceTime = parseInt(serviceTime) + parseInt(diff);

				var data = {
					'service_time' : serviceTime
				}
				$.ajax({
					url : "/rmuti-electronicqueue/Booking/updateBookingQueue/" + $('#lbl_queue_no').data('queueno') ,
					type : 'PUT',
					data : JSON.stringify(data),
					contentType: "application/json; charset=utf-8",
					async : true
				}).done(function(data) {
				}).fail(function() {
				});

				if (diff > 0){
					increaseTime(diff)
				}
			}
		},
		afterShow: function () {
			if ($('#lbl_queue_no').text() != "-"){
				beforeTime = $('#success_time').val();
			}
		}
	});
}

function statusAnima() {
	$('#lbl_status').addClass('animated pulse infinite slow');
}

function loadSideNav() {
	$("#btn_sideNav").sideNav();
}

function loadTable (){
	table = $('#dtb_queue').DataTable( {
		"processing": true,
		"pagingType": "full_numbers",
		"searching": true,
		"sDom": '<\'row\'<\'col-sm-12\'t>><\'row\'<\'col-sm-6\'l><\'col-sm-6\'p>>',
		"oLanguage": {
			"sLengthMenu": "แสดง_MENU_รายการ",
		},
		"ajax": {
			url: "/rmuti-electronicqueue/Queue/getAllQueueByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
			dataSrc: ""
		},
		"columns": [
			{ "data": "queue_no" },
			{ "data": "type_name" },
			{ "data": "service_name" },
			{ "data": "phone_number" },
			{ "data": "status_name" },
			{ "data": "waiting_time" }
		]
	} );

	$('#dtb_queue_wrapper').find('label').each(function () {
		$(this).parent().append($(this).children());
	});
	$('#dtb_queue_wrapper .dataTables_filter').find('input').each(function () {
		const $this = $(this);
		$this.attr("placeholder", "Search");
		$this.removeClass('form-control-sm');
	});
	$('#dtb_queue_wrapper .dataTables_length').addClass('d-flex flex-row');
	$('#dtb_queue_wrapper .dataTables_filter').addClass('md-form');
	$('#dtb_queue_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
	$('#dtb_queue_wrapper select').addClass('mdb-select');
	$('#dtb_queue_wrapper .mdb-select').materialSelect();
	$('#dtb_queue_wrapper .dataTables_filter').find('label').remove();
	$('#dtb_queue').parent('div .col-sm-12').addClass('table-responsive');
}

function resizeLabel() {
	if($( window ).width()<576){
		$('#col_lbl_queue').addClass('text-left');
		$('#col_lbl_queue').removeClass('text-right');
	}else {
		$('#col_lbl_queue').addClass('text-right');
		$('#col_lbl_queue').removeClass('text-left');
	}
}

function renderStatus() {
	$.ajax({
		url : "/rmuti-electronicqueue/Department/getStaustByid/01",
		type : 'GET',
		async : true
	}).done(function(data) {
		var result = JSON.parse(data);

		switch (result[0].status) {
			case '01' :
				$('#dept_regis_status').prop('checked',true);
				if (checkRole()){
					$('#btn_pause').text('พักคิว');
					$('#dept_regis_status').prop('disabled',false);
				}
			break;
			case '02' :
				$('#dept_regis_status').prop('checked',false);
				if (checkRole()){
					$('#btn_pause').prop('disabled',false);
					$('#dept_regis_status').prop('disabled',false);
				}
			break;
			case '03' :
				$('#dept_regis_status').prop('checked',true);
				$('#btn_pause').text('ยกเลิกพักคิว');
				if (checkRole()){
					$('#btn_pause').prop('disabled',false);
					$('#dept_regis_status').prop('disabled',true);
				}
			break;
		}

		if (checkRole()){
			if ($('#lbl_queue_length').text() == 'คิวที่รอ 0 คิว' && $('#btn_pause').text() == 'พักคิว' || result[0].status == '02' ){
				$('#btn_pause').prop('disabled',true);
			}else {
				$('#btn_pause').prop('disabled',false);
			}
		}
	}).fail(function() {
	});
}

function checkRole() {
	if (user_dept != '01'){
		return false;
	}else {
		return true;
	}
}

function updateSystemStatus(status) {
	var data = {
		"status": status
	}

	$.ajax({
		url : "/rmuti-electronicqueue/Department/updateDepartment/01",
		type : 'PUT',
		data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
		contentType: "application/json; charset=utf-8",
		async : true
	}).fail(function() {
		resetModal();
		Swal.fire({
			title: 'ระบบผิดพลาด',
			text: "ไม่สามารถดำเนินการได้ในขณะนี้",
			icon: 'error'
		})
	});
}

function renderQueueLength(){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCountQueueByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : true
	}).done(function(data) {
		var result = JSON.parse(data);
		if (currentQueue === null) {
			currentQueue = result;
		} else {
			if (currentQueue < result) {
				notification();
				currentQueue = result;
			}
		}

		$('#lbl_queue_length').text('คิวที่รอ ' + result + ' คิว')
		if (checkRole()){
			if ((result != 0 || $('#lbl_queue_no').text() != '-') && $('#btn_pause').text() == 'พักคิว'){
				$('#btn_next').prop('disabled',false);
			}else {
				$('#btn_next').prop('disabled',true);
			}
		}
	}).fail(function() {
	});
}

function rederQueue(){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCurrentQueueByByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			arrivalTime = moment().format('HH:mm');
			successTime = moment().add(parseInt(result[0].time), 'm').format('HH:mm');
			serviceTime = result[0].time;
			$('#success_time').val(successTime);
			$('#success_time').prop('disabled', false);
			$("#lbl_queue_no").text(result[0].queue_no);
			$("#lbl_queue_no").data('queueno',result[0].id);
			$("#lbl_user_type").text(result[0].type_name);
			$("#lbl_phone_number").text(result[0].phone_number);
			$("#lbl_service_name").text(result[0].service_name);
			if (checkRole()){
				$('#btn_cancel').prop('disabled',false);
			}
		}
	}).fail(function() {
	});
}

function nextQueue(){
	if ($('#lbl_queue_no').text() == "-") { //ไม่มีคิวก่อนหน้า
		getNextQueue();
	}else{ //่มีคิวก่อนหน้า
		var ps_time = diffTime(arrivalTime, moment().format("HH:mm"));
		var data = {
			'status' : '5',
			'process_time' : ps_time != 0 ? ps_time : 1,
			'staff_name' : $('#lbl_staff_name').text()
		}
		$.ajax({
			url : "/rmuti-electronicqueue/Booking/updateBookingQueue/" + $('#lbl_queue_no').data('queueno') ,
			type : 'PUT',
			data : JSON.stringify(data),
			contentType: "application/json; charset=utf-8",
			async : true
		}).done(function(data) {
			var result = JSON.parse(data);
			decreaseTime(serviceTime);
			getNextQueue();
		}).fail(function() {
		});
	}
}

function getNextQueue(){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getNextQueueByByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			updateQueue(result[0].id);
			arrivalTime = moment().format('HH:mm');
			successTime = moment().add(parseInt(result[0].time), 'm').format('HH:mm');
			serviceTime = result[0].time;
			$('#success_time').val(successTime);
			$("#lbl_queue_no").text(result[0].queue_no);
			$("#lbl_queue_no").data('queueno',result[0].id);
			$("#lbl_user_type").text(result[0].type_name);
			$("#lbl_phone_number").text(result[0].phone_number);
			$("#lbl_service_name").text(result[0].service_name);
			$('#btn_cancel').prop('disabled',false);
			$('#success_time').prop('disabled',false);
		}else {
			$('#success_time').prop('disabled',true);
            $("#lbl_queue_no").text('-');
            $("#lbl_queue_no").data('queueno','');
            $("#lbl_user_type").text('-');
            $("#lbl_phone_number").text('-');
            $("#lbl_service_name").text('-');
			$('#success_time').val('');
			$('#btn_cancel').prop('disabled',true);
		}
	}).fail(function() {
	});
}

function cancelQueue(){
	Swal.fire({
		title: 'ยืนยันการยกเลิกคิว',
		text: "คุณต้องการยกเลิกคิวหมายเลข "+ $('#lbl_queue_no').text() +" ?" ,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ตกลง',
		cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		if (result.value) {
			var data = {
				'status' : '4',
				'waiting_time' : 0
			}
			$.ajax({
				url : "/rmuti-electronicqueue/Booking/updateBookingQueue/" + $('#lbl_queue_no').data('queueno') ,
				type : 'PUT',
				data : JSON.stringify(data),
				contentType: "application/json; charset=utf-8",
				async : false
			}).done(function(data) {
				decreaseTime(serviceTime);
				getNextQueue();
			}).fail(function() {
			});
		}
	});
}

function validation_pause() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#btn_pause_queue').click(function() {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
				validat = false;
			}else {
				$('#dept_regis_status').prop('disabled',true);
				$('#btn_pause').text('ยกเลิกพักคิว');
				updateSystemStatus('03');
				$('#form_pause').removeClass('was-validated');
				$('#select_time > div > input').val('');
				$('#modal_pausequeue').modal('hide');

				var time_pause = parseInt($('#time_pause').val());
				var data = {
					"pause_time": time_pause
				}
				$.ajax({
					url : "/rmuti-electronicqueue/Queue/updatePauseTime/01/",
					type : 'PUT',
					data : JSON.stringify(data),
					contentType: "application/json; charset=utf-8",
					async : false
				}).done(function(data) {
					increaseTime(time_pause);
				}).fail(function() {
				});
			}
			form.classList.add('was-validated');
		});
	});
}


function pauseQueue(){
	if ($('#btn_pause').text() == 'พักคิว'){
		if ($('#lbl_queue_no').text() == "-") { //ไม่มีคิวก่อนหน้า
			$('#modal_pausequeue').modal('show');
		}else { //่มีคิวก่อนหน้า
			var ps_time = diffTime(arrivalTime, moment().format("HH:mm"));
			var data = {
				'status': '5',
				'process_time': ps_time != 0 ? ps_time : 1
			}
			$.ajax({
				url: "/rmuti-electronicqueue/Booking/updateBookingQueue/" + $('#lbl_queue_no').data('queueno'),
				type: 'PUT',
				data: JSON.stringify(data),
				contentType: "application/json; charset=utf-8",
				async: true
			}).done(function (data) {
				var result = JSON.parse(data);
				decreaseTime(serviceTime);
				$('#success_time').prop('disabled',true);
				$("#lbl_queue_no").text('-');
				$("#lbl_queue_no").data('queueno','');
				$("#lbl_user_type").text('-');
				$("#lbl_phone_number").text('-');
				$("#lbl_service_name").text('-');
				$('#success_time').val('');
				$('#btn_cancel').prop('disabled',true);
				$('#modal_pausequeue').modal('show');
			}).fail(function () {
			});
		}
	}else { //ยกเลิกพักคิว
		$('#dept_regis_status').prop('disabled',false);
		$('#btn_pause').text('พักคิว');
		updateSystemStatus('01');
		$.ajax({
			url : "/rmuti-electronicqueue/Queue/getPauseTime/01/",
			type : 'GET',
			async : false
		}).done(function(data) {
			var result = JSON.parse(data);
			var time_pause = result[0].pause_time;
			decreaseTime(time_pause);
		}).fail(function() {
		});
	}
}

function updateQueue(id){
	var data = {
		'status' : '2',
		'waiting_time' : 0
	}
	$.ajax({
		url : "/rmuti-electronicqueue/Booking/updateBookingQueue/" + id ,
		type : 'PUT',
		data : JSON.stringify(data),
		contentType: "application/json; charset=utf-8",
		async : false
	}).done(function(data) {
	}).fail(function() {
	});
}

function decreaseTime(time){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getAllQueueByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			$.each(result, function (i, v) {
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
			});
		}
	}).fail(function() {
	});
}

function increaseTime(time){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getAllQueueByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			$.each(result, function (i, v) {
				var data = {
					'waiting_time' : parseInt(v.waiting_time) + parseInt(time)
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
			});
		}
	}).fail(function() {
	});
}

function diffTime(start, end){
	var diff = moment(end,"HH:mm").diff(moment(start,"HH:mm"));
	var d = moment.duration(diff);
	return d.asMinutes()
}

function timeNow(){
	var time = moment().format('HH:mm');
	$('#lbl_time_now').text(time)
	table.ajax.reload(null, false);
	renderQueueLength();
	renderStatus();
	setTimeout(timeNow, 1000);
}

function notification(){
	var audio = new Audio('/rmuti-electronicqueue/assets/sounds/alarm.mp3');
	audio.play();
}
