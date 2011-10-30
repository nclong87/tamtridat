<?php

class TintucController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "tintuc";
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
			$this->tintuc->showHasOne('image');
			$this->tintuc->id=$id;
            $tintuc=$this->tintuc->search();
			$this->set("tintuc",$tintuc['tintuc']);
			if($tintuc['image']['id']!=null)
				$this->set("image",$tintuc['image']);
		}
		$this->_template->renderPage();
	}
	
    function listTintuc() {
		$this->checkAdmin(true);
		//$keyword = $_POST["keyword"];
		$keyword = isset($_POST["sSearch"])?$_POST["sSearch"]:null;
		$sEcho = isset($_POST["sEcho"])?$_POST["sEcho"]:'';
		$iDisplayStart = isset($_POST["iDisplayStart"])?$_POST["iDisplayStart"]:0;
		$iDisplayLength = isset($_POST["iDisplayLength"])?$_POST["iDisplayLength"]:10;
		if($keyword!=null) {
			$keyword = remove_accents($keyword);
			$this->tintuc->where("and (tintuc.id='$keyword' or valuesearch like '%$keyword%')");
			
		}
		$this->tintuc->orderBy('tintuc.id','DESC');
		$TotalRecords = $this->tintuc->search('tintuc.id,title,viewcount,datemodified,usermodified,backuped');
		$TotalDisplayRecords = array_slice($TotalRecords,$iDisplayStart,$iDisplayLength);
		$result = array('sEcho'=>$sEcho,'iTotalRecords'=>count($TotalRecords),'iTotalDisplayRecords'=>count($TotalRecords),'aaData'=>$TotalDisplayRecords);
		echo json_encode($result);
	}
	function active($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->tintuc->id = $id;
			$this->tintuc->backuped = 0;
			$this->tintuc->save();
			echo "DONE";
		}
	}
	function deactive($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->tintuc->id = $id;
			$this->tintuc->backuped = 1;
			$this->tintuc->save();
			echo "DONE";
		}
	}
	function saveTintuc() {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin(true);
		try {
			$id = $_POST["id"];
			$title = $_POST["title"];
			$alias = $_POST["alias"];
			//die('$_POST["image_id"]='.$_POST["image_id"]);
			$image_id = $_POST["image_id"]==null?'0':$_POST["image_id"];
			$thongtinchitiet = $_POST["thongtinchitiet"];
			$mota = trimString($_POST["mota"],240);
			if($id==null) { //insert
				$this->tintuc->id = null;
				$this->tintuc->title = $title;
				$this->tintuc->alias = $alias;
				$this->tintuc->mota = $mota;
				$this->tintuc->image_id = $image_id;
				$this->tintuc->thongtinchitiet = $thongtinchitiet;
				$this->tintuc->datemodified = GetDateSQL();
				$this->tintuc->usermodified = $_SESSION["account"]["username"];
				$this->tintuc->valuesearch = remove_accents("$title $thongtinchitiet $mota");
				$this->tintuc->viewcount = '0';
				$this->tintuc->backuped = '0';
				$id = $this->tintuc->insert(true);
			} else { //update
				$this->tintuc->id = $id;
				$this->tintuc->title = $title;
				$this->tintuc->alias = $alias;
				$this->tintuc->mota = $mota;
				$this->tintuc->image_id = $image_id;
				$this->tintuc->thongtinchitiet = $thongtinchitiet;
				$this->tintuc->datemodified = GetDateSQL();
				$this->tintuc->usermodified = $_SESSION["account"]["username"];
				$this->tintuc->valuesearch = remove_accents("$title $thongtinchitiet $mota");
				$this->tintuc->update();
			}
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
		
	}    
	function deleteTintuc() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->tintuc->id=$id;
		if($this->tintuc->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function view($id=null) {
		if($id != null && $id != 0) {
			$this->tintuc->showHasOne('image');
			$this->tintuc->id=$id;
            $tintuc=$this->tintuc->search();
			$this->set("tintuc",$tintuc['tintuc']);
			$this->set("image",$tintuc['image']);
			$this->set("controller",'tin-tuc');
			$this->tintuc->where(' and backuped=0');
			$this->tintuc->setLimit(5);
			$this->tintuc->setPage(1);
			$this->tintuc->orderBy('viewcount','desc');
			$lsthotnews = $this->tintuc->search();
			$this->set("lsthotnews",$lsthotnews);
			$this->_template->render();
		} else
			error('Liên kết không tồn tại!');
	}
	function tin_moi_cap_nhat($ipageindex=1) {
		$this->tintuc->showHasOne('image');
		$this->tintuc->setLimit(PAGINATE_LIMIT);
		$this->tintuc->setPage($ipageindex);
		$this->tintuc->where(' and backuped=0');
		$this->tintuc->orderBy('datemodified','desc');
		$tintucs = $this->tintuc->search();
		$totalPages = $this->tintuc->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("tintucs",$tintucs);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->set("controller",'tin-tuc');
		$this->tintuc->where(' and backuped=0');
		$this->tintuc->setLimit(5);
		$this->tintuc->setPage(1);
		$this->tintuc->orderBy('viewcount','desc');
		$lsthotnews = $this->tintuc->search();
		$this->set("lsthotnews",$lsthotnews);
		$this->_template->render();
	}
	
	function getContentById($id=null) {	
		
		if($id != null && $id != 0) {
			$this->tintuc->id=$id;
            $tintuc=$this->tintuc->search();
			print_r($tintuc['tintuc']['content']);
		}
	}
	function afterAction() {

	}

}