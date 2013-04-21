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

    
    	//$fav = self::get_fav();
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
	public function diary_get($get_str="/") {
		$host = $this->host;
		$getdata = "";
		$diary_to = "~bukreja";
		//$getdata = $diary_to;
		//$getdata .= "/";
		//$getdata .= "order=frombegin";


		$out = "GET $get_str HTTP/1.1\r\n";
		$out .= "Host: $host\r\n";
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


	public function get_headers($get_str="/") {
		$content = $this->diary_get();

		$headers = trim(mb_substr($content, 0, stripos($content, "<!DOC")));
		return $headers;

	}

	public function get_body($get_str="/") {
		//header("Content-Type: text/html; charset=utf-8");

		$content = $this->diary_get($get_str);

		$html_str = mb_substr($content, stripos($content, "<body"));
		$html_str = mb_substr($html_str, 0, stripos($html_str, "/body")+6);
		$html_str = iconv("Windows-1251", "UTF-8", $html_str);

		$html_str = "<html>"
					."<head>"
					.'<meta http-equiv="content-type" content="text/html; charset=utf-8" />'
					."</head>"
					.$html_str
					."</html>";

		return $html_str;
	}

	public function get_userprofile_url() {
		$dom = new DOMDocument();
		@$dom->loadHTML($this->get_body());


		$el = $dom->getElementById('shapka');
		//$no = $el->childNodes;
		$nl = $el->getElementsByTagName("a");
	
		if ($nl->length >= 3+1) { 
			$el = $nl->item(3);
		}
		else
			return false;
		
		
		$member_url = $el->getAttribute('href');
		
		return $member_url;
	}


	public function get_fav() {
		$favs = Array();
		$dom = new DOMDocument("1.0", "utf-8");
		if (!$this->get_userprofile_url())
			return $favs;

		
		$html = $this->get_body( $this->get_userprofile_url() );
		
		@$dom->loadHTML($html);

		$el = $dom->getElementById('content');

		$nl = $el->getElementsByTagName("p");

		//$nl = $nl->item(6)->ChildNodes;
		$nl = $nl->item(6)->childNodes; 
		foreach ($nl as $i=>$n) {
			//noindex
			if ($i == 0)
				continue;

			if($n->firstChild->nodeName == "a")
				$favs[$n->nodeValue] = $n->firstChild->getAttribute('href');
		}

		return $favs;

	}

}



/*foreach ($res as $i=>$p) {
	echo $i; echo "<br>";
	 echo $p->nodeValue, PHP_EOL;
	 echo "<br>";
}*/

//echo "<br>";


?>