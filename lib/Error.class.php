<?php

class Error {

	function __construct(){}

	static function handler($errno, $errstr, $errfile, $errline){
		switch ($errno) {
		      case E_USER_ERROR:

		      		$maniac = Maniac::getInstance();
		      		$maniac->error = $errstr;
		      		//header("Refresh: 3; url=index.php");
		      		//echo "<h3>Ошибка</h3>";
					//echo "<p style=\"color: #f00\">$errstr</p>";
					//echo "<p><a href=\"index.php\">Вернуться назад</a></p>";
		      		//exit(1);
		      break;

		      case E_USER_WARNING:
		          echo "Предупреждение: [$errno] $errstr<br />\n";
		      break;

		      case E_USER_NOTICE:
		          echo "Замечание: [$errno] $errstr<br />\n";
		      break;
		      default:
		          echo "Ужасная ошибка: [$errno] $errstr в файле $errfile в строке $errline <br />\n";
		      break;
		}
   		return true;
	}

}    


?>