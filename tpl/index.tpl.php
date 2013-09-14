<h3><?=$login?></h3>

<form method="post" action="index.php">
	<input type="hidden" name="logout">
	<input type="submit" class="submit" value="Выйти">
</form>

<h3>Любое ID юзера</h3>

<form method="get" action="<?=BASE_URL?>/archive">
	<p>ID юзера: <input type="text" name="userid"> 
	<input type="submit" value="GET"></p>
</form>

<p class="ac">OR:</p>
<?php if ($favorites): ?>
	<h3>Мои избранные</h3>
	<table class="favs" border="0">
	<?php foreach($favorites as $i=>$user): ?>
	 	<tr class="<?php echo ($i+1)%2==0 ? 'even' : 'odd'?>">
			<td class="col-1"><a href="archive/?userid=<?=$user['id']?>"><?=$user['name']?></a></td>
			<td>
				<?php if ($user['last_update']): ?>
				<a href="archive/?userid=<?=$user['id']?>">сделать архив [<?=date('Y.m.d - h:m:s',$user['last_update'])?>]</a>
				<?php else: ?>
				недоступно
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>


<?php if (!empty($readers)): ?>
	<h3>Мои постоянные читатели</h3>
	<table class="favs" border="0">
	<?php foreach($readers as $i=>$user): ?>
	 	<tr class="<?php echo ($i+1)%2==0 ? 'even' : 'odd'?>">
			<td class="col-1"><a href="archive/?userid=<?=$user['id']?>"><?=$user['name']?></a></td>
			<td>
				<?php if ($user['last_update']): ?>
				<a href="archive/?userid=<?=$user['id']?>">сделать архив [<?=date('Y.m.d - h:m:s',$user['last_update'])?>]</a>
				<?php else: ?>
				недоступно
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
