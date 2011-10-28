<?php

class DuanController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "duan";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {
		performAction('webmaster', 'updateStatistics');
	}
	function checkLogin($isAjax=false) {
		if(!isset($_SESSION['account'])) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/account/login');
				die();
			}
		}
	}
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['account']) || $_SESSION["account"]["role"]>1) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	
	function form($id=null) {
		$this->checkAdmin(false);
		if($id != null && $id != 0) {
			//$arr = array('a' => '20/1/2001', 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
			//die(json_encode($arr));
			$this->duan->showHasOne('image');
			$this->duan->id=$id;
            $duan=$this->duan->search();
			$this->set("duan",$duan['duan']);
			if($duan['image']['id']!=null)
				$this->set("image",$duan['image']);
		}
		$this->setModel("loaiduan");
		$this->loaiduan->orderBy('`tenloaiduan`','ASC');
		$lstLoaiduan = $this->loaiduan->search();
		$this->set("lstLoaiduan",$lstLoaiduan);
		$this->_template->renderPage();
	}
	
    function listDuan() {
		$this->checkAdmin(true);
		//$keyword = $_POST["keyword"];
		$keyword = isset($_POST["sSearch"])?$_POST["sSearch"]:null;
		$sEcho = isset($_POST["sEcho"])?$_POST["sEcho"]:'';
		$iDisplayStart = isset($_POST["iDisplayStart"])?$_POST["iDisplayStart"]:0;
		$iDisplayLength = isset($_POST["iDisplayLength"])?$_POST["iDisplayLength"]:10;
		if($keyword!=null) {
			$keyword = remove_accents($keyword);
			$this->duan->where("and (duan.id='$keyword' or valuesearch like '%$keyword%')");
			
		}
		$this->duan->showHasOne(array('loaiduan','account'));
		$this->duan->orderBy('duan.id','DESC');
		$TotalRecords = $this->duan->search('duan.id,tenduan,dateupdate,username,tenloaiduan,duan.backuped');
		$TotalDisplayRecords = array_slice($TotalRecords,$iDisplayStart,$iDisplayLength);
		$result = array('sEcho'=>$sEcho,'iTotalRecords'=>count($TotalRecords),'iTotalDisplayRecords'=>count($TotalRecords),'aaData'=>$TotalDisplayRecords);
		echo json_encode($result);
	}
	function activeDuan($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->duan->id = $id;
			$this->duan->backuped = 0;
			$this->duan->save();
			echo "DONE";
		}
	}
	function unActiveDuan($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->duan->id = $id;
			$this->duan->backuped = 1;
			$this->duan->save();
			echo "DONE";
		}
	}
	function saveDuan() {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin(true);
		try {
			$id = $_POST["id"];
			$tenduan = $_POST["tenduan"];
			$alias = $_POST["alias"];
			$image_id = $_POST["image_id"];
			$thongtinchitiet = $_POST["thongtinchitiet"];
			$mota = trimString($_POST["mota"],240);
			$loaiduan_id = $_POST["loaiduan_id"];
			$tenloaiduan = $_POST["tenloaiduan"];
			if($id==null) { //insert
				$this->duan->id = null;
				$this->duan->tenduan = $tenduan;
				$this->duan->alias = $alias;
				$this->duan->mota = $mota;
				$this->duan->image_id = $image_id;
				$this->duan->thongtinchitiet = $thongtinchitiet;
				$this->duan->dateupdate = GetDateSQL();
				$this->duan->account_id = $_SESSION["account"]["id"];
				$this->duan->loaiduan_id = $loaiduan_id;
				$this->duan->valuesearch = remove_accents("$tenduan $thongtinchitiet $tenloaiduan $mota");
				$this->duan->backuped = 0;
				$id = $this->duan->insert(true);
			} else { //update
				$this->duan->id = $id;
				$this->duan->tenduan = $tenduan;
				$this->duan->alias = $alias;
				$this->duan->mota = $mota;
				$this->duan->image_id = $image_id;
				$this->duan->thongtinchitiet = $thongtinchitiet;
				$this->duan->dateupdate = GetDateSQL();
				$this->duan->account_id = $_SESSION["account"]["id"];
				$this->duan->loaiduan_id = $loaiduan_id;
				$this->duan->valuesearch = remove_accents("$tenduan $thongtinchitiet $tenloaiduan $mota");
				$this->duan->update();
			}
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
		
	}    
	function deleteDuan() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->duan->id=$id;
		if($this->duan->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function view($id=null) {
		if($id != null && $id != 0) {
			$this->duan->id=$id;
            $duan=$this->duan->search();
			$this->set("duan",$duan);
		}
		$this->_template->render();
	}
	function projects($ipageindex=1) {
		$this->duan->showHasOne('image');
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->setPage($ipageindex);
		$this->duan->where(' and backuped=0');
		$this->duan->orderBy('dateupdate','desc');
		$duans = $this->duan->search();
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("duans",$duans);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->setModel('loaiduan');
		$this->loaiduan->orderBy('tenloaiduan','ASC');
		$loaiduans = $this->loaiduan->search();
		$this->set("loaiduans",$loaiduans);
		$this->set("controller",'du-an');
		$this->_template->render();
	}
	function loaiduan($loaiduan_id=null,$ipageindex=1) {
		if($loaiduan_id!=null) {
			$this->duan->showHasOne('image');
			$this->duan->setLimit(PAGINATE_LIMIT);
			$this->duan->setPage($ipageindex);
			$this->duan->where(" and backuped=0 and loaiduan_id='$loaiduan_id'");
			$this->duan->orderBy('dateupdate','desc');
			$duans = $this->duan->search();
			$totalPages = $this->duan->totalPages();
			$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
			if ($ipagesbefore < 1)
				$ipagesbefore = 1;
			$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
			if ($ipagesnext > $totalPages)
				$ipagesnext = $totalPages;
			$this->set("duans",$duans);
			$this->set('pagesindex',$ipageindex);
			$this->set('pagesbefore',$ipagesbefore);
			$this->set('pagesnext',$ipagesnext);
			$this->set('pageend',$totalPages);
			$this->setModel('loaiduan');
			$this->loaiduan->orderBy('tenloaiduan','ASC');
			$loaiduans = $this->loaiduan->search();
			$this->set("loaiduans",$loaiduans);
			foreach ($loaiduans as $loaiduan) {
				if($loaiduan['loaiduan']['id']==$loaiduan_id)
					$this->set("tenloaiduan",$loaiduan['loaiduan']['tenloaiduan']);
			}
			$this->set("loaiduan_id",$loaiduan_id);
			$this->set("controller",'du-an');
			$this->_template->render();
		}
	}
	function getContentById($id=null) {	
		
		if($id != null && $id != 0) {
			$this->duan->id=$id;
            $duan=$this->duan->search();
			print_r($duan['duan']['content']);
		}
	}
	function afterAction() {

	}

}