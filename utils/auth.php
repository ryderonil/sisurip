<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Auth{
    
    
    public static function handleLogin(){
        @session_start();
        $loggedin = $_SESSION['loggedin'];
        if(!isset($loggedin)){
            header('location:'.URL.'login/');
            
        }
    }
    
    public static function getRole(){
        return $_SESSION['userrole'];
    }
    
    public static function setRole($session, $value){        
        $_SESSION[$session] = $value;
    }
        
}
?>
