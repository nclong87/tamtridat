<div class="padding">
					<div class="wrapper margin-bot">
						<div class="col-3">
							<h4 class="p2" style="border-bottom: 1px groove gray">Các Dự Án</h4>
							<?php
							foreach ($duans as $duan) {
								$image = $duan['image'];
								$duan = $duan['duan'];
								$linkduan = BASE_PATH.'/duan/view/'.$duan['id'].'/'.$duan['alias'];
								?>
								<div class="first_text">
								<div class="cat_box1"><a href="<?php echo $linkduan?>" title="<?php echo $duan['tenduan']?>" class="left"><img alt="<?php echo $duan['tenduan']?>" src="<?php echo $image['fileurl']?>"></a>
								</div>
								<a href="<?php echo $linkduan?>" class="avata"><?php echo $duan['tenduan']?></a>
								<div class="cat_intro"><?php echo $duan['mota']?></div>
							</div>
								<?php
							}
							?>
							<div id="paging">
							<center>
							<?php 
							$linktmp = BASE_PATH.'/duan/projects';
							if($pagesbefore>1)
								echo '<a class="paging" style="padding-right:5px" href="'.$linktmp.'">1 ...</a>';
							while($pagesbefore<$pagesindex) {
								echo "<a class='paging' href='$linktmp/$pagesbefore'>$pagesbefore</a>";
								$pagesbefore++;
							}
							?>
							<a class="current_page" href="#"><?php echo $pagesindex ?></a>
							<?php 
							while($pagesnext>$pagesindex) {
								$pagesindex++;
								echo "<a class='paging' href='$linktmp/$pagesindex'>$pagesindex</a>";
							}
							if($pagesnext<$pageend)
								echo "<a class='paging' style='padding-right:5px' href='$linktmp/$pageend'>... $pageend</a>";
							?>
							</center>
							</div>
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