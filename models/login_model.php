<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Login_Model extends Model{
    //put your code here
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }
    
    public function auth(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
        $sth = $this->prepare($sql);
        
        $sth->bindValue(":username", $username);
        $sth->bindValue(":password", $password);
        
        $sth->execute();
        
        $sth->fetchAll();
        
        $int = $sth->rowCount();
        
        if($int>0){
            Session::createSession();
            Session::set('loggedin',$username);
            header('location:../suratmasuk');
        }else{
            header('location:../login');
        }
        
        /*
         *if($username=='admin' AND $password='password'){
            header('location:../suratmasuk');
            }else{
            header('location:../login');
            }
         */
        
        
    }
    
}
?>
