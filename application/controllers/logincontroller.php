<?php

class LoginController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		$this->flagRedirect = false;
		$this->_action = $action;
		$this->_template =& new Template($controller,$action);

	}
	function beforeAction () {
		performAction('webmaster', 'updateStatistics');
	}
	function isLoged() {
		if(!isset($_SESSION['account'])) {
			return false;
		}
		return true;
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function index() {
		$this->_template->renderLoginPage();  	  
	}  
	function doLogin() {
		
	}
	function afterAction() {

	}

}