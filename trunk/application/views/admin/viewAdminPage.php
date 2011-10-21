<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<script src="<?php echo BASE_PATH ?>/public/js/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_PATH ?>/public/js/jquery.jeditable.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>/public/css/demo_page.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>/public/css/demo_table_jui.css" />
<div style="padding-top:10px;font-size:14px" >
	<div style="text-align:left;padding:10px;width:90%;float:left;">
		<div id="top_icon" style="padding-top:0;">
		  <div align="center">
			<div><a href="#"><img src="<?php echo BASE_PATH ?>/public/images/icons/add_icon.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
					<span class="toplinks">
			  <a href="#" onclick="showDialogPage()"><span class="toplinks">THÊM PAGE</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Page</legend>
		<div id="datagrid">
			<table width="100%" id="dataTable">
				<thead>
					<tr>
						<td width="20px">#</td>
						<td>Tiêu đề</td>
						<td>URL View</td>
						<td>Menu</td>
						<td width="110px">Ngày cập nhật</td>
						<td width="110px">Người cập nhật</td>
						<td>Active</td>
						<td width="40px">Xử lý</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="8" class="dataTables_empty">Loading data from server...</td>
					</tr>
				</tbody>
			</table>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function loadListPages() {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/page/listPages/true"),
			success : function(data){	
				//alert(data);
				unblock("#datagrid");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
				} else {
					$("#datagrid").html(data);
					$("input:submit, input:button", "#datagrid").button();	
				}
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	function deletePage() {
		if(byId("page_id").value=="") {
			alert("Vui lòng chọn page cần xóa!");
			return;
		}
		if(!confirm("Bạn muốn xóa page này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogPage #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/page/deletePage&id="+byId("page_id").value),
			success: function(data){
				unblock("#dialogPage #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Thao tác bị lỗi!',0);	
				} else {
					closeDialog('#dialogPage');
					loadListPages(1);
					message("Xóa page thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogPage #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/page/activePage/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Page thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Page này'></div>");
				} else {
					message("Active Page không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	function doUnActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/page/unActivePage/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Page thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active Page này'></div>");
				} else {
					message("Bỏ Active Page không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	function doEdit(id) {
		window.open(url('/page/form/'+id),'Page Form','resizable=yes,menubar=no,toolbar=no,status=no,width=1000');
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Page");
		oTable = $('#dataTable').dataTable({
			"bJQueryUI": true,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": url("/page/listPages"),
			"aoColumns": [
						{ "mDataProp": "id","bSortable": false },
						{ "mDataProp": "title","bSortable": false },
						{ "mDataProp": "alias","bSortable": false },
						{ "mDataProp": "menu_id","bSortable": false},
						{ "mDataProp": "datemodified","bSortable": false },
						{ "mDataProp": "usermodified","bSortable": false },
						{ "mDataProp": "active","bSortable": false },
						{ "mDataProp": null,"bSortable": false,"sClass":"td_remove" }
					],
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				$.ajax( {
					"dataType": 'json', 
					"type": "POST", 
					"url": sSource, 
					"data": aoData, 
					"success": fnCallback
				} );
			},
			"sPaginationType": "full_numbers"
		});
		$('#dataTable_filter input').unbind();
		$('#dataTable_filter input').bind('keyup', function(e) {
			if(e.keyCode == 13) {
				oTable.fnFilter(this.value);	
			}
		});
	});
</script>