<?php

/* 
* Класс-одиночка Maniac
* Front Controller
*/
class Maniac{
	private $_settings;
    private $_updated = false;
    static $_instance;
    static $test = 0;
    public $login = NULL;
    public $password = NULL;
    public $error = 0;
    private $_params = Array();
    public $blog;
    private $_controller;
    private $_action;
    private $_body;

    static $count = 1;

    public static function getInstance(){
        /*Maniac::$test++;
        echo Maniac::$test;*/
        if(!(self::$_instance instanceof self))  {
            self::$_instance = new self(); 
        }
        return self::$_instance;
    }

    private function __clone(){} 

    private function __construct(){

        if (isset($_SESSION['user_login']) && isset($_SESSION['user_pass']) ) {
            $this->login = $_SESSION['user_login'];
            $this->password = $_SESSION['user_pass'];
         }
       

        $this->_settings = parse_ini_file('conf/config.ini');
        $request = str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']) ;
        if (strpos($request, '?')!==false) {
            $request = substr($request, 0, strpos($request, '?'));
        }

        $splits = explode('/', trim($request,'/'));
        
        $this->_controller = (!empty($splits[0]) && strpos($splits[0], '.')===false) ? ucfirst($splits[0]).'Controller' : 'IndexController';
        $this->_action = !empty($splits[1]) ? $splits[1].'Action' : 'defaultAction';
        // Параметры флаги
        if(!empty($splits[2])){
            for($i=2, $cnt = count($splits); $i<$cnt; $i++){
               $this->_params['flags'][] = $splits[$i];
            } 
        }
        // Параметы GET
        if(!empty($_GET)){
            foreach($_GET as $k => $v) {
                $this->_params[$k] = $v;
            }
        }
    }
   

    public function router() {
        $this->blog = BlogFactory::returnBlog();
         // log-in
        if (isset($_POST['user_login']) && isset($_POST['user_pass'])) {
            $this->login = $_POST['user_login'];
            $this->password = $this->blog->create_password($_POST['user_pass']);

            if ($this->blog->auth()) {
                $_SESSION['user_login'] = $this->login;
                $_SESSION['user_pass'] = $this->password;

                DB::getInstance()->addUser(Array(
                                                 ':login'=>$this->login,
                                                 ':password'=>$this->password,
                                                 ':blog_resource'=>$this->blog->name,
                                                 ':status'=>1));
                header("Location: ".BASE_URL);
            }
            else {
                echo $this->error;
            }
         }
         
         // log-out
         elseif (isset($_POST['logout']) ) {
                unset($_SESSION['user_login']);
                unset($_SESSION['user_pass']);
                header("Location: ".BASE_URL);
         }  

         else {
            $rc = new ReflectionClass($this->getController());
            if($rc->hasMethod($this->getAction())) {
                $controller = $rc->newInstance();
                $action = $rc->getMethod($this->getAction());
                $action->invoke($controller);
            } else {
                throw new Exception("Wrong Action");
            }
        }
      
    }

    public function getParams() {
        return $this->_params;
    }
    public function getController() {
        return $this->_controller;
    }
    public function getAction() {
        return $this->_action;
    }
    public function getBody() {
        return $this->_body;
    }
    public function setBody($body) {
        $this->_body = $body;
    }
}
?>