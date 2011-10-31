<script type="text/javascript" src="<?php echo BASE_PATH?>/public/js/slides.min.jquery.js"></script>
<link rel="stylesheet" href="<?php echo BASE_PATH?>/public/css/slide.css">
<div class="padding">
	<div id="container">
		<div id="example">
			<img src="<?php echo BASE_PATH?>/public/images/new-ribbon.png" width="112" height="112" alt="New Ribbon" id="ribbon">
			<div id="slides">
				<div class="slides_container">
					<?php
					foreach($cache->get('newprojects') as $data) {
						$linkview = BASE_PATH.'/duan/view/'.$data['duan']['id'].'/'.$data['duan']['alias'];
						?>
						<div class="slide">
							<a href="<?php echo $linkview?>" title="<?php echo $data['duan']['tenduan']?>"><img src="<?php echo BASE_PATH.$data['image']['fileurl']?>" width="860" height="350" alt="<?php echo $data['duan']['tenduan']?>"></a>
							<div class="caption" style="bottom:0">
								<p><span style="font-size:20px"><?php echo trimString($data['duan']['tenduan'],60)?></span></p>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<a href="#" class="prev"><img src="<?php echo BASE_PATH?>/public/images/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="<?php echo BASE_PATH?>/public/images/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
			</div>
			<img src="<?php echo BASE_PATH?>/public/images/example-frame2.png" width="900" height="400" alt="Example Frame" id="frame">
		</div>
	</div>
	<div class="wrapper">
		<div class="col-3">
			<div class="indent">
				<h4>LỊCH SỬ HÌNH THÀNH VÀ PHÁT TRIỂN</h4>
				<p class="color-4 p1">Tiền thân từ Công ty CP Sàn Giao Dịch BĐS Bến Thành (Sàn Bến Thành) - một doanh nghiệp trẻ hoạt động trong lĩnh vực đầu tư, kinh doanh và dịch vụ bất động sản. Tuy mới thành lập từ đầu năm 2009, trong thời gian thị trường bất động trầm lắng, nhưng  Sàn Bến Thành đã để lại những dấu ấn riêng của mình. Từng bước hình thành và phát triển thương hiệu Sàn Bến Thành trên thị trường bất động sản không chỉ tại TP.Hồ Chí Minh mà còn vươn ra phạm vi cả nước.</p>
				<div class="wrapper">
					<figure class="img-indent3"><img src="images/page1-img1.png" alt="" /></figure>
					<div class="extra-wrap">
						<div class="indent2">
							Trong nỗ lực phục vụ khách hàng ngày một tốt hơn, là một địa chỉ tin tưởng của khách hàng trong lĩnh vực BĐS. Sàn Bến Thành đã liên kết với Công ty CP Đức Khải thành lập thành Công ty CP BĐS Bến Thành – Đức Khải, mang một tầm vóc mới, sức mạnh mới. Sức mạnh của doanh nghiệp trẻ đầy nhiệt huyết và năng động, một tầm vóc của những con người dám nghĩ, dám làm. Từ đó cung cấp cho khách hàng những sản phẩm, dịch vụ tốt nhất trong ngành đĩa ốc; là nơi an cư, lập nghiệp của khách hàng. Đóng góp một phần sức lực cho sự phát triển kinh tế xã hội và của cộng đồng.
						</div>
					</div>
				</div>
				<a class="button-2" href="page/view/18/gioi-thieu">Chi Tiết</a>
			</div>
		</div>
		<div class="col-4">
			<div class="block-news">
				<h4 class="p2" style="border-bottom: 1px groove gray">Tin Tức</h4>
				<?php
				foreach($cache->get('lastnews') as $news) {
					$linknews = BASE_PATH.'/tintuc/view/'.$news['tintuc']['id'].$news['tintuc']['alias'];
					$month = $html->format_date($news["tintuc"]["datemodified"],'m');
					$day = $html->format_date($news["tintuc"]["datemodified"],'d');
					?>
					<div class="wrapper">
						<time class="tdate-1 fleft" datetime="2011-05-29"><strong><?php echo $day ?></strong>Tháng <?php echo $month ?></time>
						<div class="extra-wrap">
							<h5><?php echo $news['tintuc']['title']?></h5> 
							<?php echo $news['tintuc']['mota']?><br/><a title="<?php echo $news['tintuc']['title']?>" href="<?php echo $linknews?>">Chi tiết</a>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<script>
 $(function(){
	$('#slides').slides({
		preload: true,
		preloadImage: url('public/images/loading_slide.gif'),
		play: 5000,
		slideSpeed: 1000,
		fadeSpeed: 0,
		hoverPause: true,
		animationStart: function(current){
			$('.caption').animate({
				bottom:-50
			},100);
			if (window.console && console.log) {
				// example return of current slide number
				console.log('animationStart on slide: ', current);
			};
		},
		animationComplete: function(current){
			$('.caption').animate({
				bottom:0
			},200);
			if (window.console && console.log) {
				// example return of current slide number
				console.log('animationComplete on slide: ', current);
			};
		},
		slidesLoaded: function() {
			$('.caption').animate({
				bottom:0
			},200);
		}
	});
});
</script>