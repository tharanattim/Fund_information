var table;
var myChart;

$(function () {
	$('#loading-page').show();
	$.when(
		loadSideNav(),
		loadTable(),
		loadGraph([],[],[]),
		loadDatepicker(),
		resizeLabel()
	).done(function () {
		$('#loading-page').hide();
	});
	$( window ).resize(function() {
		resizeLabel();
	});
})

function loadSideNav() {
	$("#btn_sideNav").sideNav();
}

function loadTable (){
	table = $('#dtb_queue').DataTable({
		"processing": true,
		"pagingType": "full_numbers",
		"searching": false,
		"sDom": '<\'row\'<\'col-sm-12\'t>><\'row\'<\'col-sm-6\'l><\'col-sm-6\'p>>',
		"oLanguage": {
			"sLengthMenu": "แสดง_MENU_รายการ"
		},
		"ajax": {
			url: "/rmuti-electronicqueue/Queue/getQueueLogsByDate/0/0",
			dataSrc: ""
		},
		"columns": [
			{ "data":"queue_no" },
			{ "data":"dept_name" },
			{ "data":"type_name" },
			{ "data":"service_name" },
			{ "data":"phone_number" },
			{ "data":"time_stamp" },
			{ "data":"status" },
			{ "data":"process_time" },
			{ "data":"staff_name" }
		],
		"order": [[ 5, "asc" ]]
	});
	$('#dtb_queue_wrapper').find('label').each(function () {
		$(this).parent().append($(this).children());
	});
	$('#dtb_queue_wrapper select').removeClass('custom-select custom-select-sm form-control form-control-sm');
	$('#dtb_queue_wrapper select').addClass('custom-select-dtb');
}

function  searchQueue(dateFrom, dateTo){
	if (dateFrom !== '0' && dateTo !== '0'){
		var dateFromSplit  = dateFrom.split('-').reverse();
		dateFromSplit[0] = parseInt(dateFromSplit[0]) - 543;
		dateFrom = dateFromSplit.join('-');
		var dateToSplit  = dateTo.split('-').reverse();
		dateToSplit[0] = parseInt(dateToSplit[0]) - 543;
		dateTo = dateToSplit.join('-');
	}
	table.ajax.url(`/rmuti-electronicqueue/Queue/getQueueLogsByDate/${dateFrom}/${dateTo}`).load();
}

function loadGraph(dept1, dept2, dept3) {
	var ctx = document.getElementById('myChart').getContext('2d');
	myChart = new Chart(ctx,
		{
			type: 'bar',
			data: {
				labels: ["08.00-09.59", "10.00-11.59", "12.00-13.59", "14.00-16.30"],
				datasets: [
					{
						label: "ทะเบียนนักศึกษา",
						backgroundColor: "rgba(83, 131, 236, 0.2)",
						borderColor: "rgba(83, 131, 236,1)",
						data: dept1,
						borderWidth: 1
					}, {
						label: "ตรวจสอบและรับรองผลการศึกษา",
						backgroundColor: "rgba(90, 197, 96, 0.2)",
						borderColor: "rgba(90, 197, 96,1)",
						data: dept2,
						borderWidth: 1
					}, {
						label: "สำเร็จการศึกษา",
						backgroundColor: "rgba(245, 190, 81, 0.2)",
						borderColor: "rgba(245, 190, 81,1)",
						data: dept3,
						borderWidth: 1
					}
				]
			},
			options: {
				scales: {
					yAxes : [{
						ticks : {
							min : 0
						}
					}]
				},
				legend: {
					labels: {
						fontFamily : 'Kanit-Light'
					}
				}
			}
		}
	);
}

function loadDatepicker() {
	var mm = moment().add(543, 'year');
	$.extend($.fn.pickadate.defaults, {
		monthsFull: [ 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม' ],
		monthsShort: [ 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.' ],
		weekdaysFull: [ 'อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหสับดี', 'ศุกร์', 'เสาร์' ],
		weekdaysShort: [ 'อ.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.' ],
		today: 'วันนี้',
		clear: 'ลบ',
		close: 'ปิด',
		format: `dd-mm-${mm.year()}`
	})

	var from_input = $('#dateFrom').pickadate();
	var from_picker = from_input.pickadate('picker');
	var to_input = $('#dateTo').pickadate();
	var to_picker = to_input.pickadate('picker');

	if (from_picker.get('value')) {
		to_picker.set('min', from_picker.get('select'))
	}
	if (to_picker.get('value')) {
		from_picker.set('max', to_picker.get('select'))
	}

	from_picker.on('set', function (event) {
		if (event.select) {
			to_picker.set('min', from_picker.get('select'))
			if ($('#dateTo').val() !== ''){
				searchQueue($('#dateFrom').val(), $('#dateTo').val());
				getQueueChart($('#dateFrom').val(), $('#dateTo').val());
				$('#btn_print').prop('disabled', false);
			}
		} else if ('clear' in event) {
			to_picker.set('min', false)
			if ($('#dateTo').val() === ''){
				searchQueue( '0', '0');
				myChart.destroy();
				loadGraph([],[],[]);
			}
			$('#btn_print').prop('disabled', true);
		}
	})
	to_picker.on('set', function (event) {
		if (event.select) {
			from_picker.set('max', to_picker.get('select'))
			if ($('#dateFrom').val() !== ''){
				searchQueue( $('#dateFrom').val(), $('#dateTo').val());
				getQueueChart($('#dateFrom').val(), $('#dateTo').val());
				$('#btn_print').prop('disabled', false);
			}
		} else if ('clear' in event) {
			from_picker.set('max', false)
			if ($('#dateFrom').val() === ''){
				searchQueue( '0', '0');
				myChart.destroy();
				loadGraph([],[],[]);
			}
			$('#btn_print').prop('disabled', true);
		}
	})
}

function getQueueChart(dateFrom, dateTo){
	var dateFromSplit  = dateFrom.split('-').reverse();
	dateFromSplit[0] = parseInt(dateFromSplit[0]) - 543;
	dateFrom = dateFromSplit.join('-');
	var dateToSplit  = dateTo.split('-').reverse();
	dateToSplit[0] = parseInt(dateToSplit[0]) - 543;
	dateTo = dateToSplit.join('-');
	$.ajax({
		url : `/rmuti-electronicqueue/Queue/getQueueLogsByDate/${dateFrom}/${dateTo}`,
		type : 'GET',
		async : true
	}).done(function(data) {
		let result = JSON.parse(data);
		if (result.length != 0){
			let dept1List = [];
			let dept2List = [];
			let dept3List = [];
			let timePhase1 = 0;
			let timePhase2 = 0;
			let timePhase3 = 0;
			let timePhase4 = 0;
			for (let data of result){
				if (data.department === '01')
					dept1List.push(data);
				if (data.department === '02')
					dept2List.push(data);
				if (data.department === '03')
					dept3List.push(data);
			}
			for (let dept of dept1List){
				let time  = dept.time_stamp.split(' ');
				time = time[1];
				time = time.split(':');
				let h = parseInt(time[0]);
				if (h >= 8 && h <= 9)
					timePhase1 += 1;
				if (h >= 10 && h <= 11)
					timePhase2 += 1;
				if (h >= 12 && h <= 13)
					timePhase3 += 1;
				if (h >= 14 && h <= 16)
					timePhase4 += 1;
			}
			dept1List = [];
			dept1List[0] = timePhase1;
			dept1List[1] = timePhase2;
			dept1List[2] = timePhase3;
			dept1List[3] = timePhase4;
			timePhase1 = 0;
			timePhase2 = 0;
			timePhase3 = 0;
			timePhase4 = 0;
			for (let dept of dept2List) {
				let time = dept.time_stamp.split(' ');
				time = time[1];
				time = time.split(':');
				let h = parseInt(time[0]);
				if (h >= 8 && h <= 9)
					timePhase1 += 1;
				if (h >= 10 && h <= 11)
					timePhase2 += 1;
				if (h >= 12 && h <= 13)
					timePhase3 += 1;
				if (h >= 14 && h <= 16)
					timePhase4 += 1;
			}
			dept2List = [];
			dept2List[0] = timePhase1;
			dept2List[1] = timePhase2;
			dept2List[2] = timePhase3;
			dept2List[3] = timePhase4;
			timePhase1 = 0;
			timePhase2 = 0;
			timePhase3 = 0;
			timePhase4 = 0;
			for (let dept of dept3List) {
				let time = dept.time_stamp.split(' ');
				time = time[1];
				time = time.split(':');
				let h = parseInt(time[0]);
				if (h >= 8 && h <= 9)
					timePhase1 += 1;
				if (h >= 10 && h <= 11)
					timePhase2 += 1;
				if (h >= 12 && h <= 13)
					timePhase3 += 1;
				if (h >= 14 && h <= 16)
					timePhase4 += 1;
			}
			dept3List = [];
			dept3List[0] = timePhase1;
			dept3List[1] = timePhase2;
			dept3List[2] = timePhase3;
			dept3List[3] = timePhase4;
			myChart.destroy();
			loadGraph(dept1List, dept2List, dept3List);
		} else  {
			myChart.destroy();
			loadGraph([],[],[]);
		}
	}).fail(function() {
		myChart.destroy();
		loadGraph([],[],[]);
	});
}

function resizeLabel() {
	if($( window ).height()>570){
		$('#col_dateFrom').addClass('text-left');
		$('#col_dateFrom').removeClass('text-right');
	}else {
		$('#col_dateFrom').addClass('text-right');
		$('#col_dateFrom').removeClass('text-left');
	}
}

function downLoadQueueLogsReport(){
	var dateFrom = $('#dateFrom').val();
	var dateTo = $('#dateTo').val();
	var dateFromSplit  = dateFrom.split('-').reverse();
	dateFromSplit[0] = parseInt(dateFromSplit[0]) - 543;
	dateFrom = dateFromSplit.join('-');
	var dateToSplit  = dateTo.split('-').reverse();
	dateToSplit[0] = parseInt(dateToSplit[0]) - 543;
	dateTo = dateToSplit.join('-');
	window.location.replace(`/rmuti-electronicqueue/Queue/downloadQueueLogs/${dateFrom}/${dateTo}`);
}
