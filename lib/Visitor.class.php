<?php

class Visitor {
	private $host = "m.diary.ru";

	private $user_login;
	private $user_pass;
	private $sock;

	public function __construct(Maniac $maniac){
		$this->user_login = urlencode($maniac->login);
		$this->user_pass = $maniac->password;
    	$this->sock = fsockopen($this->host, 80, $sock_errno, $sock_errmsg, 30);

    
    	echo self::get_userprofile_url();
    }

    public function diary_post() {
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
    }

    /* 
    * Получить содержимое
    */
	public function diary_get() {
		$getdata = "";
		$diary_to = "~bukreja";
		//$getdata = $diary_to;
		//$getdata .= "/";
		//$getdata .= "order=frombegin";


		$out = "GET / HTTP/1.1\r\n";
		$out .= "Host: m.diary.ru\r\n";
		$out .= "Cookie:user_login=" . $this->user_login . "; user_pass=" . $this->user_pass . ";\r\n";
		$out .= "\r\n\r\n";

		fwrite($this->sock, $out);

		$content = "";

		$piece = "";

		while ( strpos($piece, "</html>") === false && !feof($this->sock)) {
			$piece = fgets($this->sock, 1000);
			$content .= $piece;	 

		}

		return $content;
	}


	public function get_headers() {
		$content = $this->diary_get();

		$headers = trim(mb_substr($content, 0, stripos($content, "<!DOC")));
		return $headers;

	}

	public function get_body() {
		//header("Content-Type: text/html; charset=utf-8");

		$content = $this->diary_get();

		
		$html_str = mb_substr($content, stripos($content, "<body"));
		$html_str = mb_substr($html_str, 0, stripos($html_str, "/body")+6);
		$html_str = iconv("Windows-1251", "UTF-8", $html_str);

		return $html_str;

	}

	public function get_userprofile_url() {
		$dom = new DOMDocument();
		@$dom->loadHTML($this->get_body());


		$el = $dom->getElementById('shapka');
		//$no = $el->childNodes;
		$nl = $el->getElementsByTagName("a");

		$member_url = $nl->item(3)->getAttribute('href');

		return $member_url;
	}

}






?>