<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Restore extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function backup(){
        
    }
    
    public function restore(){
        
    }
    
    public function cekFile($file){
        if(file_exists($file)){
            return true;
        }else{
            return false;
        }
    }
    
    public function order($file){
        if(cekFile($file)){
            
        }
        return;
    }
}
?>
