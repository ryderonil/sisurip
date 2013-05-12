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
        return $_SESSION['role'];
    }
    
    public static function setRole($session, $value){        
        $_SESSION[$session] = $value;
    }
    
    public static function isRole($value,$role){
        if($value==$role) return true;
        return false;
    }
    
    public static function isBagian($value,$bagian){
        if($value==$bagian) return true;
        return false;
    }
    
    public static function isAllow($roleuser,$role, $bagianuser=null, $bagian=null ){
        if(is_null($bagian)){
            if($role==$roleuser){
                return true;
            }
        }
        elseif($role==$roleuser AND $bagian==$bagianuser){
            return true;
        }
        
        return false;
    }
    
        
}
?>
