var validat;

$(function () {
	$('#loading-page').show();
	$.when(
		loadSideNav(),
		timeNow()
	).done(function () {
		$('#loading-page').hide();
	});
})

function loadChats() {
	var total_dept_1 = parseInt($('#lbl_sumq_dept1').text());
	var total_dept_2 = parseInt($('#lbl_sumq_dept2').text());
	var total_dept_3 = parseInt($('#lbl_sumq_dept3').text());
	var total_queue = total_dept_1 + total_dept_2 + total_dept_3;
	var dept_1 = (total_dept_1 * 100) / total_queue;
	var dept_2 = (total_dept_2 * 100) / total_queue;
	var dept_3 = (total_dept_3 * 100) / total_queue;
	dept_1 = dept_1.toFixed(2);
	dept_2 = dept_2.toFixed(2);
	dept_3 = dept_3.toFixed(2);
	var ctxD = document.getElementById("doughnutChart").getContext('2d');
	var myChart = new Chart(ctxD, {
		type: 'doughnut',
		data: {
			labels: ["ทะเบียนนักศึกษา", "ตรวจสอบและรับรองผล", "สำเร็จการศึกษา"],
			datasets: [{
				data: [dept_1, dept_2, dept_3],
				backgroundColor: ["#4658f7", "#19bf1a", "#fda716"],
			}]
		},
		options: {
			responsive: true,
			legend: {
				labels: {
					fontFamily: 'Kanit-Regular'
				}
			},
			animation: {
				duration: 0
			}
		}
	});
}

function loadSideNav() {
	$("#btn_sideNav").sideNav();
}

function renderStatisticsDept1(){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCountAllQueueByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		var total_queue = result;
		if (total_queue != 0){
			$.ajax({
				url : "/rmuti-electronicqueue/Queue/getCountSuccessQueueByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				var success_queue = result;
				var progress = (success_queue * 100) / total_queue;
				$('#lbl_sumq_dept1').text(total_queue);
				$('#lbl_successq_dept1').text(success_queue);
				$('#progress_dept1').css('width', progress + '%');
			}).fail(function() {
				$('#lbl_successq_dept1').text('0');
				$('#progress_dept1').css('width', '0%');
			});
		}else {
			$('#lbl_sumq_dept1').text('0');
			$('#lbl_successq_dept1').text('0');
			$('#progress_dept1').css('width', '0%');
		}
	}).fail(function() {
		$('#lbl_sumq_dept1').text('0');
		$('#lbl_successq_dept1').text('0');
		$('#progress_dept1').css('width', '0%');
	});
}

function renderStatisticsDept2(){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCountAllQueueByDeptAndDate/02/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		var total_queue = result;
		if (total_queue != 0){
			$.ajax({
				url : "/rmuti-electronicqueue/Queue/getCountSuccessQueueByDeptAndDate/02/" + moment().format("YYYY-MM-DD"),
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				var success_queue = result;
				var progress = (success_queue * 100) / total_queue;
				$('#lbl_sumq_dept2').text(total_queue);
				$('#lbl_successq_dept2').text(success_queue);
				$('#progress_dept2').css('width', progress + '%');
			}).fail(function() {
				$('#lbl_successq_dept2').text('0');
				$('#progress_dept2').css('width', '0%');
			});
		}else {
			$('#lbl_sumq_dept2').text('0');
			$('#lbl_successq_dept2').text('0');
			$('#progress_dept2').css('width', '0%');
		}
	}).fail(function() {
		$('#lbl_sumq_dept2').text('0');
		$('#lbl_successq_dept2').text('0');
		$('#progress_dept2').css('width', '0%');
	});
}

function renderStatisticsDept3(){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCountAllQueueByDeptAndDate/03/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		var total_queue = result;
		if (total_queue != 0){
			$.ajax({
				url : "/rmuti-electronicqueue/Queue/getCountSuccessQueueByDeptAndDate/03/" + moment().format("YYYY-MM-DD"),
				type : 'GET',
				async : false
			}).done(function(data) {
				var result = JSON.parse(data);
				var success_queue = result;
				var progress = (success_queue * 100) / total_queue;
				$('#lbl_sumq_dept3').text(total_queue);
				$('#lbl_successq_dept3').text(success_queue);
				$('#progress_dept3').css('width', progress + '%');
			}).fail(function() {
				$('#lbl_successq_dept3').text('0');
				$('#progress_dept3').css('width', '0%');
			});
		}else {
			$('#lbl_sumq_dept3').text('0');
			$('#lbl_successq_dept3').text('0');
			$('#progress_dept3').css('width', '0%');
		}
	}).fail(function() {
		$('#lbl_sumq_dept3').text('0');
		$('#lbl_successq_dept3').text('0');
		$('#progress_dept3').css('width', '0%');
	});
}

function timeNow(){
	renderStatisticsDept1();
	renderStatisticsDept2();
	renderStatisticsDept3();
	loadChats();
	setTimeout(timeNow, 2000);
}


