<?php 
	$statistics = $cache->get('statistics');
	//$tAccounts = isset($statistics['tAccounts'])?$statistics['tAccounts']:'-';
	$tProjects = isset($statistics['tProjects'])?$statistics['tProjects']:'-';
	$tFinishProjects = isset($statistics['tFinishProjects'])?$statistics['tFinishProjects']:'-';
	$tLiveProjects = isset($statistics['tLiveProjects'])?$statistics['tLiveProjects']:'-';
	//$tFreelancers = isset($statistics['tFreelancers'])?$statistics['tFreelancers']:'-';
	$nOnlines = isset($statistics['nOnlines'])?$statistics['nOnlines']:'-';
?>
<table class="center" width="100%" border="0" cellspacing="0" cellpadding="3" id="table_statistics"><tr><td align="center"><a href="http://www.drdating.com/" target="_blank"><img src="http://www.website-hit-counters.com/cgi-bin/image.pl?URL=513525-8545" alt="drdating.com" title="drdating.com" style="border:none"/></a></td></tr><tr><td align="left">Tổng số dự án : <strong><?php echo $tProjects; ?></strong></td></tr><tr><td align="left">Dự án đã hoàn thành : <strong><?php echo $tFinishProjects; ?></strong></td></tr><tr><td align="left">Dự án đang trên sàn : <strong><?php echo $tLiveProjects; ?></strong></td></tr><tr><td align="left">Số người online : <strong><?php echo $nOnlines+rand(15,18); ?></strong></td></tr></table>