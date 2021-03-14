$(function () {
	$('#loading-page').show();
	$.when(
		validation_login()
	).done(function () {
		$('#loading-page').hide();
	});
})

function validation_login() {
	var forms = $('.needs-validation');
	Array.prototype.filter.call(forms, function(form) {
		$('#username , #password').keypress(function (e) {
			if (e.which == 13) {
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}else {
					checkLogin();
				}
				form.classList.add('was-validated');
			}
		});
		$('#btn_login').click(function() {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
			}else {
				checkLogin();
			}
			form.classList.add('was-validated');
		});
	});
}

function checkLogin() {
	var data = {
		"username" : $('#username').val().trim(),
		"password" : $('#password').val().trim()
	}

	$.ajax({
		url : "/rmuti-electronicqueue/Login/checkLogin",
		type : 'POST',
		data : JSON.stringify(data), //แปลงJavaScript Object ให้เป็น JSON แล้วส่งข้อมูลไปแบบ JSON
		contentType: "application/json; charset=utf-8",
		async : false
	}).done(function(data) { //POST สำเร็จ return เป็นจริง
		var result = JSON.parse(data);
		if (result == true){
			window.location.href = base_url+"Dashboard";
		}else{
			if (result == 'user not found'){
				Swal.fire({
					title: 'ผิดพลาด',
					text: "ไม่พบบัญชีผู้ใช้งานนี้",
					icon: 'error'
				})
			}else {
				Swal.fire({
					title: 'ผิดพลาด',
					text: "รหัสผ่านไม่ถูกต้อง",
					icon: 'error'
				})
			}
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
