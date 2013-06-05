<h3><?=$maniac->login?></h3>

<form method="post" action="index.php">
	<input type="hidden" name="logout">
	<input type="submit" class="submit" value="Выйти">
</form>

<h3>Мои избранные</h3>



<?php if (isset($favorites)): ?>
	<?php foreach($favorites as $name=>$link): ?>
		<a href="<?=$link?>"><?=$name?></a>
	<?php endforeach; ?>

<?php endif; ?>

