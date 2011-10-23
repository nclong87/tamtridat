<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/slides.min.jquery.js"></script> 
<div id="div_content" style="width:100%;">
	<div id="slides" style="margin-top:15px" >
		<div class="slides_container">
	<?php
	if(isset($images)) {
		foreach($images as $image)
			echo '<img src="'.$image['image']['fileurl'].'" />';
	}
	?>
		</div>
	</div>
</div>
<script>
	$(function(){
		$("#slides").slides({
			preload: true,
			preloadImage :'<?php echo BASE_PATH ?>/public/images/loading.gif',
			generatePagination:false,
			pagination: false,
			slideSpeed:500,
			play :5000
		});

	});
</script>