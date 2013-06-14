<?php

class Visitor {



	public function __construct(Maniac $maniac){

		$lj = new Livejournal($maniac);
		$lj->query();

		/*$this->user_login = urlencode($maniac->login);
		$this->user_pass = $maniac->password;
    	$this->sock = fsockopen($this->host, 80, $sock_errno, $sock_errmsg, 30);

    	$this->sock_lj = fsockopen($this->host_lj, 80, $sock_errno, $sock_errmsg, 30);
*/

    }

}    


?>