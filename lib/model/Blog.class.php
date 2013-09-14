<?php

abstract class Blog {
	private $maniac;

	public function __construct(){
		//$this->blog = new Diary();
		//echo " BBBB "; 
		//Maniac::getInstance();

    }

    public function get_fav() { 
		return $this->blog->get_fav();
	}
	public function login_error() { 
		return false;
		//Maniac::getInstance();
		//return $this->blog->login_error();
	}
	public function set_password() { 
		return $this->blog->get_password();
	}
}    