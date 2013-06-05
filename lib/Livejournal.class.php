<?php

class Livejournal {
	private $host = "livejournal.com";

	private $user_login;
	private $user_pass;
	private $sock;

	public function __construct(Maniac $maniac){
		
		$this->user_login = urlencode($maniac->login);
		$this->user_pass = $maniac->password;

    	


    	$this->sock = fsockopen("208.93.0.128", 80, $sock_errno, $sock_errmsg, 30);

    
    	//$fav = self::get_fav();
    }



    /* 
    * Получить содержимое
    */
	public function diary_get($get_str="/") {


		$post_data = "mode=login&user=test&password=test";

		$out = "POST /interface/flat HTTP/1.1\r\n";
		$out .= "www.livejournal.com\r\n";
		$out .= "Content-Type:application/x-www-form-urlencoded\r\n";
		$out .= "Content-Length:".strlen($post_data)."\r\n\r\n";
		$out .= $post_data;

		$host = $this->host;
		

		//fwrite($this->sock, $out);

		$content = "FF";

		$piece = "";

		/*while (!feof($this->sock)) {
			$piece = fgets($sock, 1000);
			echo $piece;
		}*/

		/*while ( strpos($piece, "</html>") === false && !feof($this->sock)) {
			

		}*/

		return $content;
	}

	


}


?>