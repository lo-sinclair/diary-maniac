<?php

class IBlogAPI {
	private $host;

	private $user_login;
	private $user_pass;
	private $sock;

	private $auth_params;


	public function query ($query, $get_str="/") {
	}

	public function login_error() {
	}

	private function login() {
	}
	
	public function get_fav() { 
		return false;
	}

	public function get_headers($out) {
	}

}
?>