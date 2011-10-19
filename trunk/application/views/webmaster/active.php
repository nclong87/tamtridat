<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<style type="text/css">
	.tdLabel {
		text-align:right;
		width:133px;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Bước 2: Kích hoạt tài khoản</div>
	<div style="width:100%">
	<center>
	<input type="hidden" name="account_id" id="account_id" value="<?php echo $account_id ?>"/>
	<div class="divTable" style="width:100%">
		<div class="tr" style="border:none;padding-top:5px">
			<div class="td" id="msg"></div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			Chúng tôi vừa gửi cho bạn 1 email xác nhận, vui lòng kiểm tra email <span style="color:red;font-weight: bold;"><?php echo $_SESSION["account"]['username'] ?></span> (có thể nằm trong thư rác) để xác nhận việc đăng ký của bạn.<br/>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Nhập mã xác nhận :</div>
			<div class="td tdInput">
			<input type="text" name="active_code" id="active_code" style="width:50%" value="" tabindex=1/>&nbsp;&nbsp;<input id="btsubmit" type="button" value="Xác Nhận" onclick="doActive()">
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			<a class="link" href="javascript:doSendActiveCode();">Gửi lại mã xác nhận?</a>
			</div>
		</div>
	</div>
	</center>
	</div>
</div>
<script type="text/javascript">
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function doSendActiveCode() {
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/webmaster/doSendActiveCode"),
			success: function(data){
				unblock("#content");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == 'ERROR_MANYTIMES') {
					message('Lỗi! Yêu cầu gửi lại mã xác nhận quá nhiều!',0);
					return;
				}
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					message('Gửi lại mã xác nhận thành công! Vui lòng kiểm tra mail để lấy mã xác nhận.',1);
				} else {
					message('Hệ thống đang quá tải, vui lòng thử lại!',0);
				}
			},
			error: function(data){ unblock("#content");alert (data);}	
		});
	}
	function doActive() {
		var account_id = byId('account_id').value;
		if(account_id == '') {
			alert('Lỗi');
			return;
		}
		checkValidate=true;
		validate(['require'],'active_code',["Vui lòng nhập mã xác nhận!"]);
		if(checkValidate == false)
			return;
		var active_code = byId('active_code').value;
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/webmaster/doActive&account_id="+account_id+"&active_code="+active_code),
			success: function(data){
				$('#btsubmit').removeAttr('disabled');
				if(data == "ERROR_WRONG") {
					message('Mã xác nhận không chính xác!',0);
					return;
				}
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					location.href = url("/account/updateinfo");
				} else {
					message('Xác nhận tài khoản không thành công!',0);
				}
			},
			error: function(data){ $('#btsubmit').removeAttr('disabled');alert (data);}	
		});
	}
	$(document).ready(function() {
		$("input:submit, input:button", "body").button();
	});
</script>
