<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo BASE_PATH ?>/public/css/backend/images/favico.ico" type="image/x-icon">
		<title>Trang Quản Trị - Form Dự Án</title>         
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
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/sprinkle.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.stringToSlug.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
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
<form id="myForm">
<input type="hidden" name="id" id="id" value="" />
<input type="hidden" name="image_id" id="image_id" value="" />
<fieldset>
	<legend><span style="font-weight:bold;">Thông Tin Dự Án</span></legend>
	<table class="center" width="80%">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="90px" style="width:90px" align="left">Tên dự án :</td>
				<td align="left">
					<input type="text" name="tenduan" id="tenduan" style="width:95%"/>
					<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
				</td>										
			</tr>
			<tr>
				<td align="left">URL Alias :</td>
				<td align="left">
					<input type="text" name="alias" id="alias" style="width:95%"/>
				</td>										
			</tr>
			<tr>
				<td align="left">Loại dự án :</td>
				<td align="left">
					<select name="loaiduan_id" id="loaiduan_id">
						<option value="">--Chọn loại dự án--</option>
						<?php
						foreach($lstLoaiduan as $loaiduan) {
							echo "<option value='".$loaiduan["loaiduan"]["id"]."'>".$loaiduan["loaiduan"]["tenloaiduan"]."</option>";
						}
						?>
					</select>
				</td>										
			</tr>
			<tr>
				<td colspan="2" align="left">
				Thông tin chi tiết : (<a href="#" onclick="showImagesPanel()">Mở Gallery</a>)<br/>
				<textarea name="thongtinchitiet" id="thongtinchitiet" class="tinymce"><?php echo isset($data)?$data['thongtinchitiet']:''?></textarea>
				</td>
			</tr>	
			</form>
			<tr>
				<td align="left">Hình ảnh :</td>
				<td align="left">
					<form id="formUpload">
					<span id="div_filedinhkem"><input type="file" name="fileupload" id="fileupload" onchange="doUploadFile()" tabindex=5/> (Size < 2Mb)</span>
					<span id="fileuploaded"></span>
					</form>
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center" height="50px">
					<input onclick="doSave()" value="Lưu" type="button">
					<input onclick="doReset()" value="Reset" type="button">
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>
</center>
</body>
</html>
<script>
	function doReset() {
		$("#myForm")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		byId("id").value="";
		$('#thongtinchitiet').html("");
		$("#myForm :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function doSave() {
		//alert($("#loaiduan_id option:selected")[0].text);return;
		checkValidate=true;
		validate(['require'],'tenduan',["Vui lòng nhập tên dự án!"]);
		validate(['requireselect'],'loaiduan_id',["Vui lòng chọn loại dự án!"]);
		if(checkValidate == false)
			return;
		if(byId("id").value!="") {
			if(!confirm("Bạn muốn cập nhật dự án này?"))
				return;
		}
		dataString = $("#myForm").serialize()+'&tenloaiduan='+$("#loaiduan_id option:selected")[0].text;
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("body");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/duan/saveDuan&"),
			data: dataString,
			success: function(data){
				unblock("body");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == 'DONE') {
					//Load luoi du lieu		
					message("Lưu dự án thành công!",1);		
				} else {
					message('Lưu dự án không thành công!',0);			
				}
			},
			error: function(data){ unblock("body");alert (data);}	
		});
	}
	window.onbeforeunload = function(){
		 opener.oTable.fnDraw(false);
	}
	function doUploadFile() {
		$("#div_filedinhkem").hide();
		$("#fileuploaded").html("Uploading...");
		$('#formUpload').submit();
	}
	$(document).ready(function(){	
		$("#tenduan").stringToSlug({
			setEvents: 'blur',
			getPut: '#alias',
			space: '-'
		});
		$('#thongtinchitiet').tinymce({
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
		$('#formUpload').ajaxForm({ 
			url:        url("/file/uploadImg"), 
			type:      "post",
			success:    function(data) { 
				//data = data.body.childNodes[0].data;	
				$("#fileuploaded").html('');
				if(data == "ERROR_FILESIZE") {
					$("#div_filedinhkem").show();
					message("File upload phải nhỏ hơn 2Mb!",0);
					return;
				}
				if(data == AJAX_ERROR_WRONGFORMAT) {
					$("#div_filedinhkem").show();
					message("Upload file sai định dạng!",0);
					return;
				}
				if(isNaN(data) == true) {
					$("#div_filedinhkem").show();
					message("Lỗi hệ thống, vui lòng thử lại sau!",0);
				} else {
					byId("msg").innerHTML="";
					byId("image_id").value = data;
					idchosen = "chosen_"+data;
					$("#div_filedinhkem").hide();
					$("#fileuploaded").html('<div style="display: block;" id="'+idchosen+'" ") class="chosen-container"><span class="chosen">'+byId("fileupload").value+'<img onclick="removechosen('+data+')" class="btn-remove-chosen" src="<?php echo BASE_PATH?>/public/images/icons/close_8x8.gif"/></span></div>');
				} 
			},
			error : function(data) {
				$("#div_filedinhkem").show();
				alert(data);
			} 
		});
		<?php
		if(isset($data)) {
			
			?>
			byId("id").value = '<?php echo $data['id']?>'
			byId("tenduan").value = '<?php echo $data['tenduan']?>'
			byId("alias").value = '<?php echo $data['alias']?>'
			$("#loaiduan_id option[value=<?php echo $data['loaiduan_id']?>]").attr("selected", true);
			<?php
		}
		?>
		$("input:submit, input:button", "body").button();
	});
	
</script>