<script src="<?php echo BASE_PATH ?>/public/js/jquery.galleryview-2.1.1-pack.js" type="text/javascript"></script>
<script src="<?php echo BASE_PATH ?>/public/js/jquery.timers-1.2.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/galleryview.css" type="text/css" media="screen">
<div id="div_content" style="width:100%;">
	<center>
	<ul id="photos" style="text-align:left">
	<?php
	if(isset($datas)) {
		foreach($datas as $data) {
			$linkview = BASE_PATH.'/duan/view/'.$data['duan']['id'].'/'.$data['duan']['alias'];
			?>
			<li>
				<span class="panel-overlay" title="<?php echo $data['duan']['tenduan']?>"><a style="filter:none" href="<?php echo $linkview ?>" ><?php echo trimString($data['duan']['tenduan'],60)?></a></span>
				<?php echo '<img title="" src="'.$data['image']['fileurl'].'" />'?>
			</li>
			<?php
		}
	}
	?>
	</ul>
	</center>
</div>
<script>
	 $(document).ready(function(){
		$('#photos').galleryView({
			panel_width: 950,
			frame_width: 50,
			frame_height: 50,
			show_filmstrip: true,
			pause_on_hover: true,
			panel_scale: 'crop',
			frame_scale: 'crop'
		});
		$(".panel").click(function() {
			//get the link href 
			var link = jQuery("a", this).attr('href');
			window.location.href = link;
		});
	  });
</script>