<div class="padding">
<div class="wrapper margin-bot">
	<div class="col-3">
		<h4 class="p2" style="margin-bottom:5px"><?php echo $duan["tenduan"]?></h4>
		<div id="intro" style="float:left">
			<div class="picture-medium">
				<div class="body">
					<a title="<?php echo $duan['tenduan']?>" href="#">
						<img width="250px" alt="<?php echo $duan['tenduan']?>" title="<?php echo $duan['tenduan']?>" src="<?php echo BASE_PATH.$image['fileurl']?>">
					</a>
				</div>
				<div class="bottom">
				<center>
				<img src="<?php echo BASE_PATH.'/public/css/images/picture-200-shadow-bottom.jpg'?>"/>
				</center>
				</div>
			</div>
			<div class="description"><?php echo $duan['mota']?></div>
		</div>
		<div id="detail">
			<?php echo $duan["thongtinchitiet"]?>
		</div>
	</div>
	<div class="col-4">
		<div class="block-news">
			<h4 class="p2" style="border-bottom: 1px groove #00A9FF">Loại Dự Án</h4>
			<ul class="list-2">
				<?php
				foreach($cache->get('loaiduan') as $loaiduan) {
					$linkloaiduan = BASE_PATH.'/duan/loaiduan/'.$loaiduan['loaiduan']['id'];
					echo '<li><a href="'.$linkloaiduan.'">'.$loaiduan['loaiduan']['tenloaiduan'].'</a></li>';
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