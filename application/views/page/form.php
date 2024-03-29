<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo BASE_PATH ?>/public/css/backend/images/favico.ico" type="image/x-icon">
		<title>Trang Quản Trị - Form Page</title>         
		<link href="<?php echo BASE_PATH ?>/public/css/backend/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo BASE_PATH ?>/public/css/backend/form.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
		
		input.ui-button {
			border:medium none;
			padding:1px 1em;
		}
		.input {
			width:86%;
		}
		select {
			margin-right:-5px;
		}
		.select {
			width:86%;
		}
		</style>
		<!--[if !IE]> 
		<-->
		<style type="text/css">
			fieldset {
				border:1px solid #A6C9E2;
				-moz-border-radius:5px 5px 5px 5px;
			}
		</style>
		<!--> 
		<![endif]-->
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery_blockUI.js"></script>		
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/constances.js"></script>	
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.stringToSlug.js"></script>
		<script type="text/javascript">
			function block(id) {
				$(id).block({ 
					message: '<span style="color:white">Đang tải dữ liệu...</span>', 
					css: { 
						border: 'none', 
						padding: '15px', 
						backgroundColor: '#000', 
						'-webkit-border-radius': '10px', 
						'-moz-border-radius': '10px', 
						opacity: .5, 
						color: '#fff' 
					} 
				}); 
			}
			function unblock(id) {
				$(id).unblock(); 
			}
			function byId(id) {
				return document.getElementById(id);
			}
			function jsdebug(data) {
				alert(data);
			}
			var url_base = '<?php echo BASE_PATH ?>';
			function url(url) {
				return url_base+url;
			}
			function message(msg,type) {
				if(type==1) { //Thong diep thong bao
					str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
					byId("msg").innerHTML = str;
				} else if(type == 0) { //Thong diep bao loi
					str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
					byId("msg").innerHTML = str;
				}
			}
		</script>
    </head>	
<body>
<center>
<form id="formPage">
<input type="hidden" name="page_id" id="page_id" value="" />
<fieldset>
	<legend><span style="font-weight:bold;">Thông Tin Page</span></legend>
	<table class="center" width="99%">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="75px" style="width:75px" align="left">Tiêu Đề :</td>
				<td align="left">
					<input type="text" name="page_title" id="page_title" style="width:95%"/>
					<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
				</td>										
			</tr>
			<tr>
				<td align="left" style="width:75px">URL Alias :</td>
				<td align="left">
					<input type="text" name="page_alias" id="page_alias" style="width:95%"/>
				</td>										
			</tr>
			<tr>
				<td align="left" style="width:75px">Menu :</td>
				<td align="left">
					<select name="page_menu" id="page_menu">
						<option value="0">--Chọn Menu--</option>
						<?php
						foreach($lstMenus as $menu) {
							echo "<option value='".$menu["menu"]["id"]."'>".$menu["menu"]["name"]."</option>";
						}
						?>
					</select>
				</td>										
			</tr>
			<tr>
				<td colspan="2" align="left">
				Nội dung : (<a href="#" onclick="showImagesPanel()">Mở Gallery</a>)<br/>
				<textarea name="page_content" id="page_content"><?php echo isset($data)?$data['content']:''?></textarea>
				</td>
			</tr>					
			<tr>
				<td colspan="6" align="center" height="50px">
					<input onclick="savePage()" value="Lưu" type="button">
					<input onclick="doReset()" value="Reset" type="button">
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>
</form>
</center>
</body>
</html>
<script>
	function doReset() {
		$("#formPage")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("page_id").value="";
		$('#page_content').html("");
		$("#formPage :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function savePage() {
		checkValidate=true;
		validate(['require'],'page_title',["Vui lòng nhập tiêu đề Trang!"]);
		if(checkValidate == false)
			return;
		if(byId("page_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Page này?"))
				return;
		}
		CKEDITOR.instances['page_content'].updateElement();
		dataString = $("#formPage").serialize();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("body");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/page/savePage&"),
			data: dataString,
			success: function(data){
				unblock("body");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == 'DONE') {
					//Load luoi du lieu		
					message("Lưu Page thành công!",1);		
				} else {
					message('Lưu Page không thành công!',0);			
				}
			},
			error: function(data){ unblock("body");alert (data);}	
		});
	}
	window.onbeforeunload = function(){
		 opener.loadListPages();
	}
	$(document).ready(function(){	
		$("#page_title").stringToSlug({
			setEvents: 'blur',
			getPut: '#page_alias',
			space: '-'
		});
		CKEDITOR.replace( 'page_content',
		{
			fullPage : true,
			extraPlugins : 'docprops'
		});
		<?php
		if(isset($data)) {
			
			?>
			byId("page_id").value = '<?php echo $data['id']?>'
			byId("page_title").value = '<?php echo $data['title']?>'
			byId("page_alias").value = '<?php echo $data['alias']?>'
			$("#page_menu option[value=<?php echo $data['menu_id']?>]").attr("selected", true);
			<?php
		}
		?>
		$("input:submit, input:button", "body").button();
	});
	
</script>