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
								<div id="intro" style="float:left">
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
									<div class="description"><?php echo $duan['mota']?></div>
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