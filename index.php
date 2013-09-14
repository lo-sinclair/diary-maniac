<?php
try {
	session_start();

	set_include_path(get_include_path()
						.PATH_SEPARATOR.'lib/'
						.PATH_SEPARATOR.'lib/interface/'
						.PATH_SEPARATOR.'lib/controllers/'
						.PATH_SEPARATOR.'lib/model/');

	function __autoload($class){
		require_once($class.'.class.php');
	}


	/*unset($_SESSION['user_login']);
	unset($_SESSION['user_pass']);
	unset($_SESSION['sid']);
	exit();*/


	define ('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));
	define ('TEMPLATE_DIR', 'tpl');

	//set_error_handler('Error::handler', E_ALL);
	 
	$maniac = Maniac::getInstance();
	$maniac->router();
	echo $maniac->getBody();

} catch (Exception $e) {
	echo $e->getMessage();
}


?>