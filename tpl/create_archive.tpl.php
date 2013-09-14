<div id="archive">
	<h3><?php print $user['name']; ?></h3>

	<p>Дневник обновлялся: <?= $user['last_update']; ?></p>
	<p>Количество записей: <?= $user['posts_count']; ?></p>
	<p>Страниц: <?= $user['pades_count']; ?></p>

	<div>
		<a id="showposts"  href="<?=BASE_URL?>/archive/getposts/?userid=<?=$user['id']?>">Просмотреть записи</a>
		<span id="load"></span>
	</div>

	<div id="posts"></div>

</div>

