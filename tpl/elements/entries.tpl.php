

<div class="pager"><?= $pager ?></div>
	<div class="content">
		<?php foreach($entries as $post ): ?>
			<div class="date">[<?=$post['date']?>]</div>
			<h4 class="title"><?=$post['title']?></h4>
			<p><?=$post['body']?></p>
			<hr>
		<?php endforeach; ?>
	</div>
<div class="pager"><?= $pager ?></div>

