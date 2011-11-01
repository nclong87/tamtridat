<div class="padding">
					<div class="wrapper margin-bot">
						<div class="col-3">
							<h4 class="p2" style="border-bottom: 1px groove #00A9FF">Tin Mới Cập Nhật</h4>
							<div style="float: left; padding-bottom: 30px; width: 100%;">
							<?php
							foreach ($tintucs as $tintuc) {
								$image = $tintuc['image'];
								$tintuc = $tintuc['tintuc'];
								$linktintuc = BASE_PATH.'/tintuc/view/'.$tintuc['id'].'/'.$tintuc['alias'];
								?>
								<div id="intro" style="float:left;margin-bottom: 20px;">
									<div class="picture-medium">
										<div class="body">
											<a title="<?php echo $tintuc['title']?>" href="<?php echo $linktintuc?>">
												<img width="250px" alt="<?php echo $tintuc['title']?>" title="<?php echo $tintuc['title']?>" src="<?php echo BASE_PATH.$image['fileurl']?>">
											</a>
										</div>
										<div class="bottom">
										<center>
										<img src="<?php echo BASE_PATH.'/public/css/images/picture-200-shadow-bottom.jpg'?>"/>
										</center>
										</div>
									</div>
									<div class="description">
									<a title="<?php echo $tintuc['title']?>" href="<?php echo $linktintuc?>"><?php echo $tintuc['title']?></a><br/><br/>
									<?php echo $tintuc['mota']?>
									</div>
								</div>
								<?php
							}
							?>
							</div>
							<center>
							<?php 
							$linktmp = BASE_PATH.'/tintuc/tin_moi_cap_nhat';
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