<script type="text/javascript" src="<?php echo BASE_PATH?>/public/js/tms-0.3.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH?>/public/js/tms_presets.js"></script> 
<div id="div_content" style="width:100%;">
	<div class="slider-wrapper">
	<div class="slider" id="slider1">
	 <ul class="items">
	<?php
	if(isset($datas)) {
		foreach($datas as $data) {
			$linkview = BASE_PATH.'/duan/view/'.$data['duan']['id'].'/'.$data['duan']['alias'];
			?>
			<li><img title="<?php echo $data['duan']['tenduan']?>" src="<?php echo BASE_PATH.$data['image']['fileurl']?>" alt="<?php echo $data['duan']['tenduan']?>">
				<strong class="banner">
					<strong class="b3"><a href="<?php echo $linkview?>"><?php echo trimString($data['duan']['tenduan'],60)?></a></strong>
				</strong>
			</li>
			<?php
		}
	}
	?>
		  </ul>
		  <a class="prev" href="#">prev</a>
		  <a class="next" href="#">prev</a>
		</div>
	</div>
</div>
<div class="wrapper margin-bot">
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
			<a class="button-2" href="gioi-thieu.html">Chi Tiết</a>
		</div>
	</div>
	<div class="col-4" style="margin-right:10px">
		<div class="block-news">
			<h4 class="p2" style="border-bottom: 1px groove gray">Tin Tức</h4>
			<div class="wrapper p2">
				<time class="tdate-1 fleft" datetime="2011-05-29"><strong>29</strong>Tháng 6</time>
				<div class="extra-wrap">
					<h5>Khách hàng chen chân mua đất Bình Dương</h5> 
					Ngày 14/11/2010, hơn 400 khách hàng đã đến tham dự hội nghị bán hàng đợt 3, dự án The Green River, Mỹ Phước 4, Bình Dương, do Công ty Cổ ..<a href="#">chi tiết</a>
				</div>
			</div>
			<div class="wrapper">
				<time class="tdate-1 fleft" datetime="2011-05-24"><strong>24</strong>Tháng 6</time>
				<div class="extra-wrap">
					<h5>Sea Star Suite: Vừa nghỉ dưỡng - vừa kinh doanh</h5> 
					Sở hữu căn hộ tại một khách sạn 5 sao giữa một vùng du lịch nổi tiếng của ... <a href="#">chi tiết</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	 $(document).ready(function(){
		$('#slider1')._TMS({
				prevBu:'.prev',
				nextBu:'.next',
				playBu:'.play',
				duration:800,
				easing:'easeOutQuad',
				preset:'gSlider',
				pagination:false,
				slideshow:6000,
				numStatus:false,
				pauseOnHover:true,
				banners:true,
				waitBannerAnimation:false,
				bannerShow:function(banner){
					banner
						.hide()
						.show("drop")
				},
				bannerHide:function(banner){
					banner
						.show()
						.fadeOut(500)
				}
			});
		$(".items li").click(function() {
			//get the link href 
			var link = jQuery("a", this).attr('href');
			window.location.href = link;
		});
	  });
</script>