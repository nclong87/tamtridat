<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo isset($title)?$title:SITE_NAME ?></title>
<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/layout.css" type="text/css" media="screen">
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.min.js"></script>
<script src="<?php echo BASE_PATH ?>/public/js/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo BASE_PATH ?>/public/js/cufon-replace.js" type="text/javascript"></script>
<script src="<?php echo BASE_PATH ?>/public/js/FF-cash.js" type="text/javascript"></script>
<!--[if lt IE 7]>
	<div style=' clear: both; text-align:center; position: relative;'>
		<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0"  alt="" /></a>
	</div>
<![endif]-->
<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/html5.js"></script>
	<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/ie.css" type="text/css" media="screen">
<![endif]-->
</head>
<body id="page1">
<!-- header -->
	<div class="bg">
		<div class="main">
			<header>
				<div class="row-1">
					<h1>
						<a class="logo" href="#">Tamtridat.com</a>
						<strong class="slog">CTY TNHH TƯ VẤN THIẾT KẾ XÂY DỰNG</strong>
					</h1>
					<form id="search-form" action="" method="post" >
						<fieldset>
							<div class="search-form">					
								<input type="text" name="search" value="Type Keyword Here" onBlur="if(this.value=='') this.value='Type Keyword Here'" onFocus="if(this.value =='Type Keyword Here' ) this.value=''" />
								<a href="#" onClick="document.getElementById('search-form').submit()">Search</a>									
							</div>
						</fieldset>
					</form>
				</div>
				<div class="row-2">
					<nav>
						<ul class="menu">
						<?php
						$menu_length = count($menuList);
						$i = 0;
						foreach($menuList as $menu) {
							$i++;
							$menuLiclass = '';
							$menuAclass = '';
							if($i==$menu_length)
								$menuLiclass = ' class="last-item"';
							if(isset($controller) && $controller==$menu["menu"]["id"])
								$menuAclass = 'class="active"';
							echo "<li$menuLiclass><a $menuAclass id='".$menu["menu"]["id"]."' href='".BASE_PATH.$menu["menu"]["url"]."'>".$menu["menu"]["name"]."</a></li>";
						}
						?>
						</ul>
					</nav>
				</div>
			</header>
			<section id="content">
			<?php
			include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			?>
			</section>
			<footer>
				<div class="row-top">
					<div class="row-padding">
						<div class="wrapper">
							<b>Địa Chỉ : </b>105 Tân Trang, Phường 9, Quận Tân Bình, Thành Phố Hồ Chí Minh<br/>
							<b>HotLine : </b>08.6265.1553
						</div>
					</div>
				</div>
				<div class="row-bot">
					<div class="aligncenter">
						<p class="p0"><a href="http://www.tamtridat.com/" >Bản quyền thuộc công ty ABC</a></p>
						Copyright © 2011<br>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script type="text/javascript"> Cufon.now(); </script>
	<script type="text/javascript">
		function byId(id) {
			return document.getElementById(id);
		}
		var url_base = '<?php echo BASE_PATH ?>';
		function url(url) {
			return url_base+url;
		}
		$(function(){
			
		})
	</script>
</body>
</html>
