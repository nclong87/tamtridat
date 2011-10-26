<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
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
			  <a href="#" onclick="openForm()"><span class="toplinks">THÊM PAGE</span></a></span><br />
		  </div>
		</div>
	</div>
	<div style="float:left;width:100%">
	<fieldset>
		<legend>Danh Sách Page</legend>
			<table style="width:100%" id="dataTable">
				<thead>
					<tr>
						<td width="20px">ID</td>
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
			url : url("/page/activePage/"+id),
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
			url : url("/page/unActivePage/"+id),
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
		window.open(url('/page/form/'+id),'Page','resizable=yes,menubar=no,toolbar=no,status=no,width=1000');
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Page");
		oTable = $('#dataTable').dataTable({
			"bJQueryUI": true,
			"bProcessing": true,
			"bServerSide": true,
			"bAutoWidth": false,
			"sAjaxSource": url("/page/listPages"),
			"aoColumns": [
						{ "mDataProp": "page.id","bSortable": false,"sClass":"alignCenter"},
						{ "mDataProp": "page.title","bSortable": false },
						{
							"bSortable": false,
							"fnRender": function( oObj ) {
								page = oObj['aData']['page'];
								return '/page/view/'+page['id']+'/'+page['alias']; 
							} 
						},
						{ 	"mDataProp": "page.menu_id","bSortable": false},
						{
							"bSortable": false,
							"fnRender": function( oObj ) {
								page = oObj['aData']['page'];
								return $.format.date(page['datemodified'], 'dd/MM/yyyy HH:ss');
							} 
						},
						{ 	"mDataProp": "page.usermodified","bSortable": false },
						{ 	"bSortable": false,"sClass":"alignCenter",
							"fnRender": function( oObj ) {
								page = oObj['aData']['page'];
								if(page['active']==0)
									return "<center><div class='inactive' onclick=\"doActive('"+page['id']+"')\" title='Active Page này'></div></center>";
								else if(page['active']==1)
									return "<center><div class='active' onclick=\"doUnActive('"+page['id']+"')\" title='Bỏ Active Page này'></div></center>";
								else
									return 'N/A';
							} 
						},
						{ 	"mDataProp": null,"bSortable": false,
							"fnRender": function( oObj ) {
								return '<center><img src="'+url('/public/images/icons/edit.png')+'" title="Chỉnh sửa" style="cursor:pointer" onclick="openForm(\''+page['id']+'\')"/></center>'; 
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