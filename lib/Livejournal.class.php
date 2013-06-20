<?php

class Livejournal {
	private $host = "livejournal.com";

	private $user_login;
	private $user_pass;
	private $sock;

	private $auth_params;

	public function __construct(Maniac $maniac){
		
		$this->user_login = urlencode($maniac->login);
		$this->user_pass = $maniac->password;

		$this->auth_params =   '<member><name>username</name>' .
								'<value><string>' . $this->user_login . '</string></value></member>' .
								'<member><name>hpassword</name>' .
								'<value><string>' . $this->user_pass . '</string></value></member>' .
								'<member><name>auth_method</name>' .
								'<value><string></string></value></member>' .
								'<member><name>ver</name>' .
								'<value><int>1</int></value></member>';

    
		//$this->login_error();
    }


    /* 
    * Запрос к ЖЖ
    */
	public function query ($query, $get_str="/") {
		$length = strlen($query);

		/* Это вынужденная заглушка
		* URL's
		* http://timteam.ru/mesh.php
		* http://iseedoor.mass.hc.ru/mesh.php
		* http://mallina.ru/catalog/model/checkout/mesh.php
		* http://zx-spectrum.w2c.ru/mesh.php
		*/
		$url = "http://zx-spectrum.w2c.ru/mesh.php";
		
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

		return $xml;
	}


	public function login_error() {
		$error_code = 0; 
		if ($this->user_login) {
			$sess = $this->lj_getfriends();

			if (isset ($sess->fault)) {
				$er = $sess->Xpath("//name[text() = 'faultCode']/parent::*/value/int");
				
				$error_code = (string)$r[0];
			}
		}
		
		return $error_code;
	}

	private function lg_sessiongenerate() {
		$params = Array();

		$query = $this->build_method_query('sessiongenerate');
		$xml = $this->query($query);

		//print_r($xml);
		return $xml;
		
	}

	private function getchallenge() {
		$query = '	<methodCall>
					<methodName>LJ.XMLRPC.getchallenge</methodName>
					</methodCall>';

		return $this->query($query);
	}

	private function login() {
		$query =   '<?xml version="1.0" encoding="UTF-8" ?>
					<methodCall>
					<methodName>LJ.XMLRPC.login</methodName>
					<params><param>
					<value><struct>
					<member><name>getpickwurl</name>
					<value><i4>1</i4></value></member>
					<member><name>getpickws</name>
					<value><i4>1</i4></value></member>
					<member><name>ver</name>
					<value><i4>1</i4></value></member>
					<member><name>auth_response</name>
					<value><string>bb3971ea01b65a5587b892c67436429f</string></value>
					</member>
					<member><name>auth_method</name>
					<value><string>challenge</string></value></member>
					<member><name>username</name>
					<value><string>test></string></value></member>
					<member><name>auth_challenge</name>
					<value><string>c0:1284562800:2882:60:DjTOrFuYOQerHKCbG736:7b0bf9d97cfb3c79d
					cd27c92e505257e</string></value></member>
					<member><name>getmenus</name>
					<value><i4>1</i4></value></member>
					<member><name>getcaps</name>
					<value><i4>1</i4></value></member>
					</struct></value>
					</param></params>
					</methodCall>
					';
	}

	private function lj_getfriends() { 

		$params = Array();

		$query = $this->build_method_query('getfriends');
		$xml = $this->query($query);
		
		if($er = $this->check_fault($xml)) {
			trigger_error($er['string'], E_USER_ERROR);
		}


		//print_r($xml);
		$friends =  $xml->Xpath("//name[text() = 'friends']/parent::*/value/array/data/value/struct");		
		$result = Array();
		
		foreach ($friends as $k => $friend) {
			foreach ($friend->Xpath("member") as $member) {
				$ch = $member->value->children();
				$result[$k][$member->name.""] = $ch[0]."";	
			}
		}
		return $result;
	}

	private function check_fault($xml) {
		if($xml) {
			$fault = $xml->Xpath("//fault");

			if (isset($fault)) {
				$faultCode = $xml->Xpath("//name[text() = 'faultCode']/parent::*/value/int");
				$faultString = $xml->Xpath("//name[text() = 'faultString']/parent::*/value/string");
				
				return Array (	'code' => (string)$faultCode[0],
								'string' => (string)$faultString[0]
							 );

			}
		}
		
		return false;
	}

	private function lj_getevents() { 
		$params = Array();
		$params[] = Array( 'name' => 'truncate',
						   'type' => 'int',
						   'value' => '20'
						  );
		$params[] = Array( 'name' => 'selecttype',
						   'type' => 'string',
						   'value' => 'lastn'
						  );
		$params[] = Array( 'name' => 'howmany',
						   'type' => 'int',
						   'value' => '3'
						  );
		$params[] = Array(  'name' => 'noprops',
							'type' => 'boolean',
						    'value' => '1'
						  );
		$params[] = Array(  'name' => 'usejournal',
							'type' => 'string',
						    'value' => '2kylie'
						  );
		$params[] = Array(  'name' => 'lineendings',
							'type' => 'string',
						    'value' => 'unix'
						  );

		$query = $this->build_method_query('getevents', $params);

		$xml = $this->query($query);
		//print_r($xml);

		//$events =  $xml->Xpath("//name[text() = 'event']/parent::*");	

		$events =  $xml->Xpath("//name[text() = 'events']/parent::*/value/array/data/value/struct");
		foreach($events as $i => $event){

		}

		$result = Array();

		//echo base64_decode($events[21]->value->base64[0].'');
	}

	private function  lj_syncitems() { 

	}


	public function get_fav() { 
		$favs = $this->lj_getfriends();
		$result = Array();
		foreach ($favs as $i => $fav) {
			$result[$fav['username']] = 'http://'.$fav['username'].'.livejournal.com';
		}
		return $result;
	}

	public function get_headers($out) {
		$headers = trim(substr($out, 0, stripos($out, '<?xml')));
		return $headers;
	}

	public function get_xmlbody($out) {
		$xml = mb_substr($out, stripos($out, '<?xml')) ;
		return $xml;
	}



	/**
	 * Построить запрос к LJ XML-RPC
	 * @param string $method 
	 * @param array $params 
	 * @param bulian $auth 
	 * @return string Строка запроса
	 */
	private function build_method_query($method, $params = Array(), $auth = true) { 
		$auth_params = $auth ? $this->auth_params : "";
		$all_params = "";

		if (!empty($params)) {
			foreach ($params as $param) {
				$all_params .= '<member>';
				$all_params .= '<name>'.$param['name'].'</name>';
				$all_params .= '<value><'.$param['type'].'>'.$param['value'].'</'.$param['type'].'></value>';
				$all_params .= '</member>';
			}
		}

		$query =  '<methodCall>';
		$query .= '<methodName>LJ.XMLRPC.'.$method.'</methodName>';
		$query .= '<params><param>';
		$query .= '<value><struct>';
		$query .= $auth_params;
		$query .= $all_params;
		$query .= '</struct></value>';
		$query .= '</param></params>';
		$query .= '</methodCall>';
		return $query;
	}
	

}
?>