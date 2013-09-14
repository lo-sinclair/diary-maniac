<?php

class DB {
	private $_db;
    static $_instance;

	public static function getInstance(){
        if(!(self::$_instance instanceof self))  {
            self::$_instance = new self(); 
        }
        return self::$_instance;
    }

	private function __construct(){
		$settinds = parse_ini_file('conf/config.ini');
		$conn_string = "mysql:host={$settinds['DB_HOST']};dbname={$settinds['DB_NAME']}";
		
		$this->_db = new PDO($conn_string, $settinds['DB_USER'], $settinds['DB_PASSWORD']);
    }

    private function __clone(){} 


    public function addUser($params) {
        $sql = "INSERT IGNORE INTO users 
                VALUES (0, :login, :password, :blog_resource, :status)";

        $stmt = $this->_db->prepare($sql);
        if (!$stmt->execute($params)){
            throw new Exception('Ошибка БД: '.array_pop($stmt->errorInfo()));
        }


        /*$sql = "SELECT * FROM users
                WHERE login = {$this->_db->quote($params[':login'])} AND 
                      blog_resource = {$this->_db->quote($params[':blog_resource'])}";

        $stmt = $this->_db->query($sql);
        if ($stmt===false){
              throw new Exception('Ошибка БД: '.array_pop($this->_db->errorInfo()));
        }*/

        /*if ($stmt->rowCount()==0) {
            $sql = "INSERT INTO users 
                VALUES (0, :login, :password, :blog_resource, :status)";
            $stmt = $this->_db->prepare($sql);
            if (!$stmt->execute($params)){
                  throw new Exception('Ошибка БД: '.array_pop($stmt->errorInfo()));
            }
        }*/

    	return true;
    }
	
}    