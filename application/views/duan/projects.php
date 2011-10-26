<div class="padding">
					<div class="wrapper margin-bot">
						<div class="col-3">
							<h4 class="p2" style="border-bottom: 1px groove gray">Các Dự Án</h4>
							<div class="first_text">
								<div class="cat_box1"><a href="chi-tiet-du-an.html" title="Cao ốc Văn phòng 25 Bis Nguyễn Thị Minh Khai" class="left"><img alt="Cao ốc Văn phòng 25 Bis Nguyễn Thị Minh Khai" src="images/gallery/02_minhkhai12.jpg"></a>
								</div>
								<a href="chi-tiet-du-an.html" class="avata">Cao ốc Văn phòng 25 Bis Nguyễn Thị Minh Khai</a>
								<div class="cat_intro">Vị trí: 25 Bis, Nguyễn Thị Minh Khai, Phường Đa Kao, Quận 1, TP.HCM. Dự án Cao ốc văn phòng tại 25 Bis Nguyễn Thị Minh Khai tọa lạc ngay ...</div>
							</div>
							<div class="first_text">
								<div class="cat_box1"><a href="chi-tiet-du-an.html" title="Dự án the HARMONA – cao ốc căn hộ" class="left"><img alt="Dự án the HARMONA – cao ốc căn hộ" src="images/gallery/1.jpg"></a>
								</div>
								<a href="chi-tiet-du-an.html" class="avata">Dự án the HARMONA – cao ốc căn hộ</a>
								<div class="cat_intro">The Harmona là cao ốc căn hộ kết hợp trung tâm thương mại, tọa lạc tại 33 Trương Công Định, phường 14, quận Tân Bình, do công ty Cổ Phần ...</div>
							</div>
							<div class="first_text">
								<div class="cat_box1"><a href="chi-tiet-du-an.html" title="Âu Cơ Tower" class="left"><img alt="Âu Cơ Tower" src="images/gallery/2.jpg"></a>
								</div>
								<a href="chi-tiet-du-an.html" class="avata">Âu Cơ Tower</a>
								<div class="cat_intro">Vị trí: 659, Âu Cơ, Phường Tân Thành, Quận Tân Phú, TP.HCM. Âu Cơ Tower được thiết kế theo phong cách hiện đại với mật độ xây dựng chỉ chiếm ...</div>
							</div>
							<div class="yt-uix-pager"><button class="yt-uix-pager-selected yt-uix-button" type="button"><span class="yt-uix-button-content">1</span></button><button class=" yt-uix-button" type="button" onclick="selectpage(2)"><span class="yt-uix-button-content">2</span></button><button class=" yt-uix-button" type="button" onclick="selectpage(3)"><span class="yt-uix-button-content">3</span></button><button class=" yt-uix-button" type="button" onclick="selectpage(4)"><span class="yt-uix-button-content">4</span></button></div>
						</div>
						<div class="col-4">
							<div class="block-news">
								<h4 class="p2" style="border-bottom: 1px groove gray">Loại Dự Án</h4>
								<ul class="list-2">
									<?php
									foreach($loaiduans as $loaiduan) {
										$linkloaiduan = BASE_PATH.'duan/loaiduan/'.$loaiduan['loaiduan']['id'];
										echo '<li><a href="'.$linkloaiduan.'">'.$loaiduan['loaiduan']['tenloaiduan'].'</a></li>';
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>