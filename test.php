<?php
$c_k = "418a5769c0a08c2a57f0aede3bdf5d2c";
$o_k = "d772286f61e53e8be8c06516f9cdc6de";
$password = md5($c_k.'kmpzkmpz');
$login = "loisse";
$url = "www.diary.ru/api/";

$q = "?method=user.auth&username=".$login."&password=".$password."&appkey=".$o_k;
$url.=$q;

//print_r(json_decode('{"t":"\u043C\u0430\u0442\u044C"}'));

 if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    print_r (json_decode($out));
    curl_close($curl);
 }

?>