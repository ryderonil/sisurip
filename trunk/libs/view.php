<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author aisyah
 */
class View {
    
    public function __construct() {
        $this->js = array();
    }
    
    public function render($view){
        
        if(!is_array($view)){
            require 'views/header.php';
            require 'views/'.$view;
            require 'views/footer.php';
        }else{
            echo 'view array';
        }
    }
    
    public function load($fileView){
        require 'views/'.$fileView;
    }
}

?>
