<?php




$url = "http://timteam.ru/mesh.php";


$login = "c0de_out";
$password = "1330kmpZ";

$query = '<methodCall>
<methodName>LJ.XMLRPC.sessiongenerate</methodName>
<params>
<param>
<value><struct>
<member><name>username</name>
<value><string>c0de_out</string></value></member>
<member><name>password</name>
<value><string>1330kmpZ</string></value></member>
<member><name>ver</name>
<value><int>1</int></value></member>
</struct></value>
</param>
</params>
</methodCall>';

$length = strlen($query);

$out = "POST /interface/xmlrpc HTTP/1.0\r\n";
$out .= "User-Agent: XMLRPC Client 1.0\r\n";
$out .= "Host: www.livejournal.com\r\n";
$out .= "Content-Type: text/xml\r\n";
$out .= "Content-Length: ".$length."\r\n\r\n".$query;


$post_data = array (
	"host" => "www.livejournal.com",
    "out" => $out,
    "query" => $query
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

$output = curl_exec($ch);

curl_close($ch);
echo $output;








/*session_start();

set_include_path(get_include_path()
					.PATH_SEPARATOR.'lib/'
					.PATH_SEPARATOR.'lib/view/');

function __autoload($class){
	require_once($class.'.class.php');
}



$maniac = Maniac::getInstance();

$visitor = new Visitor($maniac);







// VIEW
if ($maniac->error !== 0) {
 	$main_tpl = "error.tpl.php";
}

else {
	if (!$maniac->login) {
		$userinfo_tpl = "tpl/form_user_login.tpl.php";
	}
	else {
		$userinfo_tpl = "tpl/user_login.tpl.php";
	}
	$main_tpl = "index.tpl.php";

	//$favorites = $visitor->get_fav();
}




include "tpl/".$main_tpl;
*/














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