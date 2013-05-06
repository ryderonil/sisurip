<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Koneksi{
    
    protected $_config;
    protected $_koneksi;
    var $host;
    var $db_name;
    var $user;
    var $password;
    var $port;


    public function __construct() {}
    
    public function config($config=array()){
        if (isset($this->_koneksi)) {
			error_log('DATABASE CONNECTION::warning, koneksi ke database ini sudah dibuat');
		}

        $this->_config = array(
                'host' => $config['host'],
                'user' => $config['user'],
                'port' => $config['port'],
                'password' => $config['pass'],
                'db_name' => $config['db_name']
        );
    }
    
    public function createConnection($config=array()){
        if(is_array($config)) {
			error_log('DATABASE CONNECTION::warning, konfigurasi koneksi database tidak ada ');
		}

		if(count($config)>0) {
			foreach($config as $name => $value) {
				$this->$name=$value;
			}
		}

		//create new PDO Conncetion
		try {
			$new_connection= new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->user, $this->password);
		}catch(PDOException $e) {
			error_log('DATABASE CONNECTION::warning, gagal terkoneksi ke database. '.print_r($e, true));
			return false;
		}
		return $new_connection;
    }
    
    public function getConnection($config=array()){
        
        $this->config($config);
        $this->_koneksi=$this->createConnection($this->_config);
        return $this->_koneksi;			
		
    }
    
    private function __clone() {}
    
    public function __destruct() {}
    
}
?>
