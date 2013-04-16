<?php
session_start();

set_include_path(get_include_path()
					.PATH_SEPARATOR.'lib/'
					.PATH_SEPARATOR.'lib/view/');

function __autoload($class){
	require_once($class.'.class.php');
}



$maniac = Maniac::getInstance();

$visitor = new Visitor($maniac);


// VIEW
if (!$maniac->login) {
	$userinfo_tpl = "tpl/form_user_login.tpl.php";
}
else {
	$userinfo_tpl = "tpl/user_login.tpl.php";
}



include "tpl/index.tpl.php";















/*$post_data = "user_login=loise&user_pass=kmpzkmpz";
$out = "POST / HTTP/1.1\r\n";
$out .= "Host:www.diary.ru\r\n";
$out .= "Content-Type:application/x-www-form-urlencoded\r\n";
$out .= "Content-Length:".strlen($post_data)."\r\n\r\n";
$out .= $post_data;

fwrite($sock, $out);

$content = "";
$piece = "";

while ( strpos($piece, "</body>") === false && !feof($sock)) {
	$piece = fgets($sock, 1000);
	$content .= $piece;
	 
}*/













/*foreach ($nl as $a) {
	print_r($k);
	print_r( $a->getAttribute('href') );

}*/

//print_r ($no->item(4)->getAttribute('href'));





//echo stripos($content, "/body>", stripos($content, "<body"));








?>