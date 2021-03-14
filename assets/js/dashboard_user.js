$(function () {
	$('#loading-page').show();
	$.when(
		timeNow()
	).done(function () {
		$('#loading-page').hide();
	});
})

function timeNow(){
	rederQueue()
	setTimeout(timeNow, 1000);
}

function rederQueue(){
	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCurrentQueueByByDeptAndDate/01/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			$('#lbl_regis').text(result[0].queue_no);
		}else {
			$('#lbl_regis').text('-');
		}
	}).fail(function() {
		$('#lbl_regis').text('-');
	});

	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCurrentQueueByByDeptAndDate/02/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			$('#lbl_chack').text(result[0].queue_no);
		}else {
			$('#lbl_chack').text('-');
		}
	}).fail(function() {
		$('#lbl_chack').text('-');
	});

	$.ajax({
		url : "/rmuti-electronicqueue/Queue/getCurrentQueueByByDeptAndDate/03/" + moment().format("YYYY-MM-DD"),
		type : 'GET',
		async : false
	}).done(function(data) {
		var result = JSON.parse(data);
		if (result.length != 0){
			$('#lbl_success').text(result[0].queue_no);
		}else {
			$('#lbl_success').text('-');
		}
	}).fail(function() {
		$('#lbl_success').text('-');
	});
}

