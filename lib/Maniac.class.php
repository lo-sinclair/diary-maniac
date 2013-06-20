<?php

/* 
* Класс-одиночка Maniac
*/


class Maniac{
	private $_settings;
	private $_updated = false;
	static private $_instance = null;
	public $login = false;
    public $password = false;
    public $error = 0;
    public $visitor;

    /*
    * Контроллер
    */
    private function __construct(){
        //есть сессия
        if (isset($_SESSION['user_login']) && isset($_SESSION['user_pass']) ) {
            if (isset($_POST['logout']) ) {
                unset($_SESSION['user_login']);
                unset($_SESSION['user_pass']);
                header("Location: index.php");
            }
            else {
                $this->login = urldecode($_SESSION['user_login']);
                $this->password = urldecode($_SESSION['user_pass']);
            }
        }

        //нет сессии
        else {
            if (isset($_POST['user_login']) && isset($_POST['user_pass'])) {
                $this->login = $_POST['user_login'];
                $this->password = md5(trim($_POST['user_pass']));
                
                // проверка юзера
                $visitor = new Livejournal($this);
                //echo $visitor->login_error();

                
                $_SESSION['user_login'] = urlencode(trim($_POST['user_login']));
                $_SESSION['user_pass'] = md5(trim($_POST['user_pass']));
                header("Location: index.php");
                
             }   
        }
    }
   

    private function __clone(){} // запрещаем клонирование

    static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new Maniac();
        }
        return self::$_instance;
    }

    private function router () {
        


    }

   /* static function errorHandler($errno, $errstr, $errfile, $errline) {
        switch ($errno) {
              case E_USER_ERROR:
                      

                     echo "Ошибка: $errstr <br />\n";
                      
                    exit(1);
              break;

              case E_USER_WARNING:
                  echo "Предупреждение: [$errno] $errstr<br />\n";
              break;

              case E_USER_NOTICE:
                  echo "Замечание: [$errno] $errstr<br />\n";
              break;
              default:
                  echo "Неизвестная ошибка: [$errno] $errstr<br />\n";
              break;
        }

        return true;
    }*/
    	
    public function connectDiary() {

	}
}
?>