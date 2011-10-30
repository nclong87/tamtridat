<div class="padding">
<div class="wrapper margin-bot">
	<div class="col-3">
		<h4 class="p2" style="margin-bottom:5px"><?php echo $tintuc["title"]?></h4>
		<div id="detail">
			<?php echo $tintuc["thongtinchitiet"]?>
		</div>
	</div>
	<div class="col-4">
		<div class="block-news">
			<h4 class="p2" style="border-bottom: 1px groove gray">Tin Hot</h4>
			<ul class="list-2">
				<?php
				foreach($lsthotnews as $hotnews) {
					$linknews = BASE_PATH.'/tintuc/view/'.$hotnews['tintuc']['id'].$hotnews['tintuc']['alias'];
					echo '<li><a href="'.$linknews.'">* '.$hotnews['tintuc']['title'].'</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>
</div>
<script>
	$(document).ready(function() {
	});
</script>