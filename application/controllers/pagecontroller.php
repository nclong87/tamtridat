<?php

class PageController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "page";
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
	function view($id=null) {
		if($id != null && $id != 0) {
			$this->page->id=$id;
            $page=$this->page->search();
			$this->set("page",$page);
		}
		$this->_template->render();
	}
	function form($id=null) {
		$this->checkAdmin(false);
		if($id != null && $id != 0) {
			//$arr = array('a' => '20/1/2001', 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
			//die(json_encode($arr));
			$this->page->id=$id;
            $page=$this->page->search();
			$this->set("data",$page['page']);
		}
		$this->setModel("menu");
		$this->menu->orderBy('`order`','ASC');
		$lstMenus = $this->menu->search();
		$this->set("lstMenus",$lstMenus);
		$this->_template->renderPage();
	}
	function getContentById($id=null) {	
		
		if($id != null && $id != 0) {
			$this->page->id=$id;
            $page=$this->page->search();
			print_r($page['page']['content']);
		}
	}
    function listPages() {
		$this->checkAdmin(true);
		//$keyword = $_POST["keyword"];
		$keyword = isset($_POST["sSearch"])?$_POST["sSearch"]:null;
		$sEcho = isset($_POST["sEcho"])?$_POST["sEcho"]:'';
		$iDisplayStart = isset($_POST["iDisplayStart"])?$_POST["iDisplayStart"]:0;
		$iDisplayLength = isset($_POST["iDisplayLength"])?$_POST["iDisplayLength"]:10;
		if($keyword!=null) {
			$keyword = remove_accents($keyword);
			//$this->page->where("and (page.id='$keyword' or match(title,content) AGAINST('$keyword' IN BOOLEAN MODE) or )");
			$this->page->where("and (page.id='$keyword' or valuesearch like '%$keyword%')");
			
		}
		$this->page->orderBy('`id`','DESC');
		//$this->page->setLimit($iDisplayStart.','.$iDisplayStart+$iDisplayLength);
		$TotalRecords = $this->page->search('page.id,alias,title,datemodified,usermodified,menu_id,active');
		$TotalDisplayRecords = array_slice($TotalRecords,$iDisplayStart,$iDisplayLength);
		$result = array('sEcho'=>$sEcho,'iTotalRecords'=>count($TotalRecords),'iTotalDisplayRecords'=>count($TotalRecords),'aaData'=>$TotalDisplayRecords);
		echo json_encode($result);
		//$this->set("lstPages",$lstPages);
		//$this->_template->renderPage();
	}
	function activePage($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->page->id = $id;
			$this->page->active = 1;
			$this->page->save();
			echo "DONE";
		}
	}
	function unActivePage($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->page->id = $id;
			$this->page->active = 0;
			$this->page->save();
			echo "DONE";
		}
	}
	function savePage() {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin(true);
		try {
			$id = $_POST["page_id"];
			$title = $_POST["page_title"];
			$alias = $_POST["page_alias"];
			$menu_id = $_POST["page_menu"];
			$content = $_POST["page_content"];
			if($id==null) { //insert
				$this->setModel('page');
				$this->page->id = null;
				$this->page->title = $title;
				$this->page->alias = $alias;
				$this->page->content = $content;
				$this->page->datemodified = GetDateSQL();
				$this->page->usermodified = $_SESSION["account"]["username"];
				$this->page->menu_id = $menu_id;
				$this->page->valuesearch = remove_accents("$title $content $menu_id");
				$this->page->active = 1;
				$id = $this->page->insert(true);
			} else { //update
				$this->page->id = $id;
				$this->page->title = $title;
				$this->page->alias = $alias;
				$this->page->content = $content;
				$this->page->datemodified = GetDateSQL();
				$this->page->usermodified = $_SESSION["account"]["username"];
				$this->page->menu_id = $menu_id;
				$this->page->valuesearch = remove_accents("$title $content $menu_id");
				$this->page->save();
			}
			//$html = new HTML;
			//$value = "{'datemodified':'".$html->format_date($this->page->datemodified,'d/m/Y H:i:s')."','usermodified':'".$this->page->usermodified."'}";
			
			if(isEmpty($menu_id)==false) {
				$this->setModel("menu");
				$this->menu->id = $menu_id;
				$this->menu->url = BASE_PATH."/page/view/".$id."/".$alias;
				$this->menu->save();
				global $cache;
				$this->menu->where('AND active=1');
				$this->menu->orderBy('`order`','ASC');
				$data = $this->menu->search();
				$cache->set("menuList",$data);
			}
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
		
	}    
	function deletePage() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->page->id=$id;
		if($this->page->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function afterAction() {

	}

}