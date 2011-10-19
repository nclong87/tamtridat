<?php

/** Check if environment is development and display errors **/

function setReporting() {
if (DEVELOPMENT_ENVIRONMENT == true) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
}
}
function getUrl()  {
    /*** check for https ***/
    //$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	$protocol = 'http';
    /*** return the full address ***/
    return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 }
/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function removeMagicQuotes() {
	if ( get_magic_quotes_gpc() ) {
		$_GET    = stripSlashesDeep($_GET   );
		$_POST   = stripSlashesDeep($_POST  );
		$_COOKIE = stripSlashesDeep($_COOKIE);
	}
}
function removeHTMLTag($html) {
	return ereg_replace("<[^>]*>", "",$html);
}
/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Secondary Call Function **/

function performAction($controller,$action,$queryString=null,$render = 0) {
	
	$controllerName = ucfirst($controller).'Controller';
	$dispatch = new $controllerName($controller,$action);
	$dispatch->render = $render;
	return call_user_func_array(array($dispatch,$action),$queryString);
}
function redirect($url)
{
	header( 'Location: '.$url ) ;
}
/** Routing **/

function routeURL($url) {
	global $routing;

	foreach ( $routing as $pattern => $result ) {
            if ( preg_match( $pattern, $url ) ) {
				return preg_replace( $pattern, $result, $url );
			}
	}

	return ($url);
}
/** Upper case**/
function upper($src) {
    return mb_convert_case($src,MB_CASE_UPPER,"utf-8");
}
/** Lower case**/
function lower($src) {
    return mb_convert_case($src,MB_CASE_LOWER,"utf-8");
}
/**Math String*/
function  matchString($strResult,$strKey) {
    $strResult=str_replace("\n","<br>", $strResult);

    $temp2=upper($strKey);
    if (strlen($strKey) == 0) {
        return $strResult;
    }
    for ($i = 0; $i <= strlen($strResult) - strlen($strKey); $i++) {
        $s0 = "";
        if ($i > 0) {
            $s0 = substr($strResult,0,$i);
        }

        $s1 = substr($strResult,$i, strlen($strKey));
        $s2 = substr($strResult,($i+strlen($strKey)), strlen($strResult));
        $temp1=upper($s1);
        if (strcmp($temp1, $temp2) == 0) {
            $strResult = $s0."<span id=\"mark\" >".$s1."</span>".$s2;
            $i += 24 + strlen($strKey);
        }
    }
    return $strResult;
}
function formatMoney($str){
	$rs="";
	$dem=0;
	for($i=strlen($str)-1;$i>=0;$i--)
	{
		$dem++;
		if($dem==3 && $i>0)
		{
			$rs=".".$str[$i].$rs;
			$dem=0;
		}
		else
			$rs=$str[$i].$rs;
	}
	return $rs;
}
function getDaysFromSecond($second) {
	if($second<=0) {
		return "Đã hết hạn.";
	} 
	$d = (int)($second/86400);
	$second = $second%86400;
	$h = (int)($second/3600);
	$str = '';
	if($d>0) {
		if($h==0)
			$str = "$d ngày";
		else
			$str = "$d ngày $h giờ";
		if($d<3)
			$str = "<span style='color:red'>$str</span>";
		return $str;
	}
	$second = $second%3600;
	$m = (int)($second/60);
	if($h>0) {
		if($m==0)
			$str = "$h giờ";
		else
			$str = "$h giờ $m phút";
		$str = "<span style='color:red'>$str</span>";
		return $str;
	}
	$second = $second%60;
	if($m==0)
		$str = "$second giây";
	else
		$str = "$m phút $second giây";
	$str = "<span style='color:red'>$str</span>";
	return $str;
}
/** Main Call Function **/

function callHook() {
	global $url;
	global $default;
        
	$queryString = array();

	if (!isset($url)) {
		$controller = $default['controller'];
		$action = $default['action'];
	} else {
		$url = routeURL($url);
		$urlArray = array();
		$urlArray = explode("/",$url);
		$controller = $urlArray[0];
		array_shift($urlArray);
		if (isset($urlArray[0])) {
			$action = $urlArray[0];
			array_shift($urlArray);
		} else {
			$action = 'index'; // Default Action
		}
		$queryString = $urlArray;
	}
	
	$controllerName = ucfirst($controller).'Controller';

	$dispatch = new $controllerName($controller,$action);
	
	if ((int)method_exists($controllerName, $action)) {
		call_user_func_array(array($dispatch,"beforeAction"),$queryString);
		call_user_func_array(array($dispatch,$action),$queryString);
		call_user_func_array(array($dispatch,"afterAction"),$queryString);
	} else {
		/* Error Generation Code Here */
	}
}


/** Autoload any classes that are required **/

function __autoload($className) {
	if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
		require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
	} else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
	} else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
	} else {
		/* Error Generation Code Here */
	}
}


/** GZip Output **/

function gzipOutput() {
    $ua = $_SERVER['HTTP_USER_AGENT'];

    if (0 !== strpos($ua, 'Mozilla/4.0 (compatible; MSIE ')
        || false !== strpos($ua, 'Opera')) {
        return false;
    }

    $version = (float)substr($ua, 30); 
    return (
        $version < 6
        || ($version == 6  && false === strpos($ua, 'SV1'))
    );
}

/**Get datetime current*/
function GetDateSQL() {
    $s=date("s");
    $p=date("i");
    $h=date("H");
    $date=date("d");
    $month=date("m");
    $year=date("Y");
    return $year.'-'.$month.'-'.$date.' '.$h.':'.$p.':'.$s;
}
/**Format date*/
function SQLDate($date)
{
	if(isset($date)) {
		list($d, $m, $y) = explode('/', $date);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		return strftime('%Y-%m-%d',$mk);
	} 
	return "";
}
function addDays($this_date,$num_days,$format="Y-m-d H:i:s"){
    $my_time = strtotime ($this_date); //converts date string to UNIX timestamp
    $timestamp = $my_time + ($num_days * 86400); //calculates # of days passed ($num_days) * # seconds in a day (86400)
     $return_date = date($format,$timestamp);  //puts the UNIX timestamp back into string format
    return $return_date;//exit function and return string
}
//**Get State Form Submited*//
/** Save form state*/
function getFormState() {
    $stateForm=array();
    unset($stateForm);

    if(count($_POST)>0) {
        foreach($_POST as $key=>$value) {
            $stateForm["$key"]=$value;
        }
    }
    if(isset($stateForm))
        return $stateForm;
    return null;
}
/** Get Number In String **/
function getNum($str) {
    $rs="";
    for($i=0;$i<strlen($str);$i++) {
        if($str[$i]>='0' && $str[$i]<='9')
            $rs=$rs.$str[$i];
    }
    return $rs;
}
/** Get Required Files **/
function isNull($value) {
	if($value == null)
		return true;
	if($value == 0)
		return true;
	return false;
}
function isEmpty($value) {
	if($value==null)
		return true;
	if(empty($value))
		return true;
	return false;
}
function error($msg=" ") {
	$_SESSION["msg"] = $msg;
	redirect(BASE_PATH.'/webmaster/error');
	die();
}
function success($msg=" ") {
	$_SESSION["msg"] = $msg;
	redirect(BASE_PATH.'/webmaster/success');
	die();
}
/** Convert sign to unsign **/
function remove_accents( $str )
{
	$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ","ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ","ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ","ỳ","ý","ỵ","ỷ","ỹ","đ","À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ","È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ","Ì","Í","Ị","Ỉ","Ĩ","Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ","Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ","Ỳ","Ý","Ỵ","Ỷ","Ỹ","Đ");

	$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","e","e","e","e","e","e","e","e","e","e","e","i","i","i","i","i","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","u","u","u","u","u","u","u","u","u","u","u","y","y","y","y","y","d","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","E","E","E","E","E","E","E","E","E","E","E","I","I","I","I","I","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","U","U","U","U","U","U","U","U","U","U","U","Y","Y","Y","Y","Y","D");
	return str_replace($marTViet,$marKoDau,$str);
}

function remove_space($str) {
	$sResult = "";
	$i=0;
	$flag = false;
	$array = array(" ",",",":","'","\"","`");
	while($i<strlen($str)) {
		if(in_array($str[$i],$array)) {
			if($flag == false)
				$sResult = $sResult."-";
			$flag = true;
		} else {
			$sResult = $sResult.$str[$i];
			$flag = false;
		}
		$i++;
	}
	return $sResult;
}
//die("ee");
function genString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;
} 
function HTML2Text($html) {
	require_once(ROOT . DS . 'library' . DS .'class.html2text.inc');
	$h2t =& new html2text($html);
	// the HTML to the plain text. Store it into the variable.
	return $h2t->get_text();
}
function trimString($str,$maxlen=30) {
	if(strlen($str)<=$maxlen)
		return $str;
	return substr($str,0,$maxlen)."...";
}
function array_sort($array, $on, $order='asc') {
    $new_array = array();
    $sortable_array = array();
    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }
        switch ($order) {
            case 'asc':
                asort($sortable_array);
            break;
            case 'desc':
                arsort($sortable_array);
            break;
        }
        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}
if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == 0 ) {
	//echo 'aaa';
	gzipOutput() || ob_start("ob_gzhandler");
}

$cache =& new Cache();

$inflect =& new Inflection();
setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();


?>