<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo BASE_PATH ?>/public/css/backend/images/favico.ico" type="image/x-icon">
		<title>Admin Page</title>         
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
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery_blockUI.js"></script>		
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/constances.js"></script>	
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/sprinkle.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
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
<input type="hidden" name="page_id" id="page_id" value="<?php echo $id?>" />
<fieldset>
	<legend><span style="font-weight:bold;">Thông Tin Page</span></legend>
	<table class="center" width="80%">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="75px" align="left">Tiêu Đề :</td>
				<td align="left">
					<input type="text" name="page_title" id="page_title" style="width:95%" onblur="fillAlias()" value="<?php echo $title?>"/>
					<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
				</td>										
			</tr>
			<tr>
				<td align="left">URL Alias :</td>
				<td align="left">
					<input type="text" name="page_alias" id="page_alias" style="width:95%" value="<?php echo $alias ?>"/>
				</td>										
			</tr>
			<tr>
				<td align="left">Menu :</td>
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
				<textarea name="page_content" id="page_content" class="tinymce"><?php echo $content ?></textarea>
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
	function fillAlias() {
		value = byId("page_title").value;
		byId("page_alias").value = remove_space(remove_accents(value));
	}
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
		if(byId("page_alias").value=="") {
			fillAlias();
		}
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
		$("#page_menu option[value=<?php echo $menu_id?>]").attr("selected", true);
		$('#page_content').tinymce({
			script_url : url_base+'/public/js/tiny_mce/tiny_mce.js',
			theme : "advanced",
			width : 960,
			height : 400,
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,code,|,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,emotions,media",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			relative_urls : false,
			convert_urls : false,
			content_css : "css/content.css"
		});
		$("input:submit, input:button", "body").button();
	});
	
</script>