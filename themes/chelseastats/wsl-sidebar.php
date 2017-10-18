<?php /* Template Name: Sidebar */ ?>
<div id="sidebar" class="desktop">
	<div id="sideimages">
	<a href="https://twitter.com/ChelseaStats" class="twitter-follow-button" data-show-count="true" data-text-color = "#0080ff" data-size="small">Follow @ChelseaStats</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<br/>
	</div>
	<ul class="nav nav-list">
	<li class="nav-header">Chelsea Analysis</li>
	<?php
		$pdo = new pdodb();
		$util = new utility();
		$pdo->query('SELECT F_SQUADNO as n1, F_NAME as n2 FROM meta_wsl_squadno WHERE F_END is null order by F_SQUADNO');
		$rows = $pdo->rows();
		foreach ($rows as $row) :
			print "<li> {$row['n1']} : {$util->_V($row['n2'])} </li>".PHP_EOL;
		endforeach;
	?>
	<li class="divider"></li>
	</ul>
</div>
