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
    

    /*
    * Типа пока контроллер
    */
    private function __construct(){
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

        else {
            if (isset($_POST['user_login']) && isset($_POST['user_pass'])) {
                $this->login = $_POST['user_login'];
                $this->password = md5(trim($_POST['user_pass']));

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



    
    	
    public function connectDiary() {

	}
}
?>