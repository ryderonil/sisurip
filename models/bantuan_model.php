<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Bantuan_Model extends Model{
    //put your code here
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
        Auth::handleLogin();
    }
    
    public function show(){
        echo 10+10;
    }
}

?>
