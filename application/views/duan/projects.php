<div class="padding">
					<div class="wrapper margin-bot">
						<div class="col-3">
							<h4 class="p2" style="border-bottom: 1px groove #00A9FF">Các Dự Án</h4>
							<div style="float: left; padding-bottom: 30px; width: 100%;">
							<?php
							foreach ($duans as $duan) {
								$image = $duan['image'];
								$duan = $duan['duan'];
								$linkduan = BASE_PATH.'/duan/view/'.$duan['id'].'/'.$duan['alias'];
								?>
								<div id="intro" style="float:left;margin-bottom: 20px;">
									<div class="picture-medium">
										<div class="body">
											<a title="<?php echo $duan['tenduan']?>" href="<?php echo $linkduan?>">
												<img width="250px" alt="<?php echo $duan['tenduan']?>" title="<?php echo $duan['tenduan']?>" src="<?php echo BASE_PATH.$image['fileurl']?>">
											</a>
										</div>
										<div class="bottom">
										<center>
										<img src="<?php echo BASE_PATH.'/public/css/images/picture-200-shadow-bottom.jpg'?>"/>
										</center>
										</div>
									</div>
									<div class="description">
									<a title="<?php echo $duan['tenduan']?>" href="<?php echo $linkduan?>"><?php echo $duan['tenduan']?></a><br/><br/>
									<?php echo $duan['mota']?>
									</div>
								</div>
								<?php
							}
							?>
							</div>
							<center>
							<?php 
							$linktmp = BASE_PATH.'/duan/projects';
							if($pagesbefore>1)
								echo '<a class="paging" href="'.$linktmp.'">1</a> ... ';
							while($pagesbefore<$pagesindex) {
								echo "<a class='paging' href='$linktmp/$pagesbefore'>$pagesbefore</a> ";
								$pagesbefore++;
							}
							?>
							<a class="current_page" href="#"><?php echo $pagesindex ?></a>
							<?php 
							while($pagesnext>$pagesindex) {
								$pagesindex++;
								echo "<a class='paging' href='$linktmp/$pagesindex'>$pagesindex</a> ";
							}
							if($pagesnext<$pageend)
								echo "... <a class='paging' href='$linktmp/$pageend'>$pageend</a>";
							?>
							</center>
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