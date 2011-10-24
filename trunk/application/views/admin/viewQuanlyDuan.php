<script src="<?php echo BASE_PATH ?>/public/js/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_PATH ?>/public/js/jquery.dateFormat.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>/public/css/demo_page.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>/public/css/demo_table_jui.css" />
<div style="padding-top:10px;font-size:14px" >
	<div style="text-align:left;padding:10px;width:90%;float:left;">
		<div id="top_icon" style="padding-top:0;">
		  <div align="center">
			<div><a href="#"><img src="<?php echo BASE_PATH ?>/public/images/icons/add_icon.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
					<span class="toplinks">
			  <a href="#" onclick="openForm()"><span class="toplinks">THÊM DỰ ÁN</span></a></span><br />
		  </div>
		</div>
	</div>
	<div style="float:left;width:100%">
	<fieldset>
		<legend>Danh Sách Dự Án</legend>
			<table style="width:100%" id="dataTable">
				<thead>
					<tr>
						<td>ID</td>
						<td>Tên dự án</td>
						<td>Loại dự án</td>
						<td>Ngày cập nhật</td>
						<td>Người cập nhật</td>
						<td>Trạng thái</td>
						<td width="40px">Xử lý</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="8" class="dataTables_empty">Loading data from server...</td>
					</tr>
				</tbody>
			</table>
	</fieldset>
	</div>
</div>
<script type="text/javascript">
	function loadListPages() {
		oTable.fnDraw(false);
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
	function doActive(id) {
		//var cells = _this.parentNode.parentNode.cells;
		block("#div_content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/activeDuan/"+id),
			success: function(data){
				unblock("#div_content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					oTable.fnDraw(false);
				} else {
					alert("Có lỗi xảy ra!");
				}															
			},
			error: function(data){ alert (data);unblock("#div_content");}	
		});
	}
	function doUnActive(id) {
		//var cells = _this.parentNode.parentNode.cells;
		block("#div_content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/unActiveDuan/"+id),
			success: function(data){
				unblock("#div_content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					oTable.fnDraw(false);
				} else {
					alert("Có lỗi xảy ra!");
				}															
			},
			error: function(data){ alert (data);unblock("#div_content");}	
		});
	}
	function openForm(id) {
		window.open(url('/duan/form/'+id),'Duan','resizable=yes,menubar=no,toolbar=no,status=no,width=1000');
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Dự Án");
		oTable = $('#dataTable').dataTable({
			"bJQueryUI": true,
			"bProcessing": true,
			"bServerSide": true,
			"bAutoWidth": false,
			"sAjaxSource": url("/duan/listDuan"),
			"aoColumns": [
						{ "mDataProp": "duan.id","bSortable": false,"sClass":"alignCenter"},
						{ "mDataProp": "duan.tenduan","bSortable": false },
						{ "mDataProp": "loaiduan.tenloaiduan","bSortable": false },
						{
							"bSortable": false,
							"fnRender": function( oObj ) {
								duan = oObj['aData']['duan'];
								return $.format.date(duan['dateupdate'], 'dd/MM/yyyy HH:ss');
							} 
						},
						{ 	"mDataProp": "account.username","bSortable": false },
						{ 	"bSortable": false,"sClass":"alignCenter",
							"fnRender": function( oObj ) {
								duan = oObj['aData']['duan'];
								if(duan['backuped']==1)
									return "<center><div class='inactive' onclick=\"doActive('"+duan['id']+"')\" title='Active dự án này'></div></center>";
								else if(duan['backuped']==0)
									return "<center><div class='active' onclick=\"doUnActive('"+duan['id']+"')\" title='Bỏ Active dự án này'></div></center>";
								else
									return 'N/A';
							} 
						},
						{ 	"mDataProp": null,"bSortable": false,
							"fnRender": function( oObj ) {
								return '<center><img src="'+url('/public/images/icons/edit.png')+'" title="Chỉnh sửa" style="cursor:pointer" onclick="openForm(\''+duan['id']+'\')"/></center>'; 
							}
						}
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