<?php

class Livejournal {
	private $host = "livejournal.com";

	private $user_login;
	private $user_pass;
	private $sock;

	public function __construct(Maniac $maniac){
		
		$this->user_login = urlencode($maniac->login);
		$this->user_pass = $maniac->password;

    
    	//$fav = self::get_fav();
    }



    /* 
    * Получить содержимое
    */
	public function query ($get_str="/") {

		// Это вынужденная заглушка
		$url = "http://timteam.ru/mesh.php";

		$password = "1330kmpZ";


		$query = '<methodCall>
		<methodName>LJ.XMLRPC.sessiongenerate</methodName>
		<params>
		<param>
		<value><struct>
		<member><name>username</name>
		<value><string>'.$this->user_login.'</string></value></member>
		<member><name>'.$this->user_pass.'</name>
		<value><string>1330kmpZ</string></value></member>
		<member><name>ver</name>
		<value><int>1</int></value></member>
		</struct></value>
		</param>
		</params>
		</methodCall>';



		$query = '<methodCall>
		<methodName>LJ.XMLRPC.getchallenge</methodName>
		</methodCall>';


		$length = strlen($query);

		$out = "POST /interface/xmlrpc HTTP/1.0\r\n";
		$out .= "User-Agent: XMLRPC Client 1.0\r\n";
		$out .= "Host: www.livejournal.com\r\n";
		$out .= "Content-Type: text/xml\r\n";
		$out .= "Content-Length: ".$length."\r\n\r\n".$query;

		$post_data = array (
			"host" => "www.livejournal.com",
		    "out" => $out
		);


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
		


		

		$xml_str = $this->get_xmlbody($output);


		$xml = simplexml_load_string($xml_str);
		print_r ($xml);

		$content = "";

		return $content;
	}


	public function get_headers($out) {
		$headers = trim(substr($out, 0, stripos($out, '<?xml')));
		return $headers;
	}

	public function get_xmlbody($out) {
		$xml = mb_substr($out, stripos($out, '<?xml')) ;
		return $xml;
	}


	public function get_fav () { 



	}

}
?>