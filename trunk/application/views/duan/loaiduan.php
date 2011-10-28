<div class="padding">
					<div class="wrapper margin-bot">
						<div class="col-3">
							<h4 class="p2" style="border-bottom: 1px groove gray"><?php echo $tenloaiduan ?></h4>
							<div style="float: left; padding-bottom: 30px; width: 100%;">
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
							</div>
							<center>
							<?php 
							$linktmp = BASE_PATH.'/duan/loaiduan/'.$loaiduan_id;
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
								<h4 class="p2" style="border-bottom: 1px groove gray">Loại Dự Án</h4>
								<ul class="list-2">
									<?php
									foreach($loaiduans as $loaiduan) {
										$linkloaiduan = BASE_PATH.'/duan/loaiduan/'.$loaiduan['loaiduan']['id'];
										$classActive = '';
										if($loaiduan['loaiduan']['id']==$loaiduan_id)
											$classActive = 'class="active"';
										echo '<li><a '.$classActive.' href="'.$linkloaiduan.'">'.$loaiduan['loaiduan']['tenloaiduan'].'</a></li>';
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>