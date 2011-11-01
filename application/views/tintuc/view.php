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
			<h4 class="p2" style="border-bottom: 1px groove #00A9FF">Tin Hot</h4>
			<ul class="list-2">
				<?php
				foreach($lsthotnews as $hotnews) {
					$linknews = BASE_PATH.'/tintuc/view/'.$hotnews['tintuc']['id'].$hotnews['tintuc']['alias'];
					echo '<li><a href="'.$linknews.'">* '.$hotnews['tintuc']['title'].'</a></li>';
				}
				?>
			</ul>
		</div>
		<div class="block-news" style="padding: 5px; text-align: center; margin-top: 10px;">
			<h4 class="p2" style="border-bottom: 1px groove #00A9FF;text-align: left">Liên Hệ</h4>
			<img alt="hotline" src="<?php echo BASE_PATH?>/public/images/hotline.jpg"/><br/>
			<a class="sub-text" title="Chat with me!" href="ymsgr:sendim?nclong87"><img alt="nclong87" style="border:none" src="<?php echo BASE_PATH?>/public/images/onlineym.gif"/></a><br/>
		</div>
	</div>
</div>
</div>
<script>
	$(document).ready(function() {
	});
</script>