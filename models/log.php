<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Log extends Model{
    
    private $log;
    private $time;
    private $user;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function set($attr, $value){
        switch ($attr){
            case 'log':
                $this->log = $value;
                break;
            
        }
    }


    public function addLog(){
        
    }
    
    public function getLog(){
        
    }
    
}
?>
