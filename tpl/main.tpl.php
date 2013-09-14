<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>@Diary Maniac</title>
    <meta name="description" content="Онлайн скрипт для дайри-маньяка" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <meta http-equiv="content-type" content="text/html; charset=windows-1251" />
    <!-- <link title="Стандарт" media="all" type="text/css" href="http://static.diary.ru/style/pda.css" rel="stylesheet"> -->
    
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="<?php print BASE_URL; ?>/tpl/css/main.css" />


    <script src="<?= BASE_URL; ?>/tpl/js/lib/jquery-1.10.1.min.js"></script>
	
    <script>var baseurl = "<?=BASE_URL?>/"</script>
    <script src="<?= BASE_URL; ?>/tpl/js/init.js"></script>
    <script src="<?= BASE_URL; ?>/tpl/js/main.js"></script>

</head>
<body>
<div id ="page">
   
    <div id="header">
        <div id="logo">
        	<h1><a href="<?php print BASE_URL; ?>">@Diary Maniac</a></h1>
        </div>
    </div>

    <div id="content">
        <!-- <img src="http://static.diary.ru/userdir/1/1/3/8/1138/54208992.gif">
        тут ничо не работает
        <img src="http://static.diary.ru/userdir/1/1/3/8/1138/54208992.gif">  -->


        <?= $regions['content']; ?>
    </div>
</div>


</body>

</html>