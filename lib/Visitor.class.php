<?php

class Visitor {

	private $visitor;

	public function __construct(Maniac $maniac){

		$this->visitor = new Livejournal($maniac);

		/*$this->user_login = urlencode($maniac->login);
		$this->user_pass = $maniac->password;
    	$this->sock = fsockopen($this->host, 80, $sock_errno, $sock_errmsg, 30);

    	$this->sock_lj = fsockopen($this->host_lj, 80, $sock_errno, $sock_errmsg, 30);
*/

    }

    public function get_fav() { 
		return $this->visitor->get_fav();
	}
	public function login_error() { 
		return $this->visitor->login_error();
	}
}    


?>