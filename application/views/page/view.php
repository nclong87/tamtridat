<?php
if($page==null)
	die();
?>
<div class="padding">
	<div class="wrapper margin-bot">
		<h4 class="p2" style="border-bottom: 1px groove gray"><?php echo $page["page"]["title"]?></h4>
		<div id="detail">
			<?php echo $page["page"]["content"]?>
		</div>
	</div>
</div>
