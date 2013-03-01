<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registry
 *
 * @author aisyah
 */
class Registry {
    
    private $kelas = array();
    
    public function __set($key, $value){
        $this->kelas[$key]=$value;
    }
    
    public function __get($key){
        return $this->kelas[$key];
    }
    
}

?>
