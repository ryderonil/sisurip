<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bootstrap
 *
 * @author aisyah
 */
class Bootstrap {
    
    private $url = array();
    private $controller;
    
    public function __construct($registry) {
        //echo "</br>ini adalah bootstrap";
        $this->registry = $registry;
        
    }
    
    public function init(){
        $url = isset($_GET['page'])?$_GET['page']:null;
        //print_r($url);
        
        
        $url = rtrim($url, "/");
        $this->url = explode('/',$url);
        //print_r($url);
        //isset($url[0])?$url[0]:null;        
        //var_dump($this->url);
        $this->createController();
        $this->loadMethod($this->url);  
                
    }
    
    function createController(){
        if(isset($this->url[0])){
            $file = 'controllers/'.$this->url[0].'_controller.php';
            
            if(file_exists($file)){
                //require $file;
                
                $classController = ucfirst($this->url[0]).'_Controller';
                //echo $classController;
                $this->controller = new $classController;
                
                $this->controller->loadModel($this->url[0]);
            }else{
                $this->controller = new Suratmasuk_Controller;
                //echo "file ".$url[0].'.php tidak ada';
                $this->controller->loadModel('suratmasuk');
            }
        }
    }
    
    function loadMethod($url){
       $length = count($url);       
        
        if($length>1){
            if(!method_exists($this->controller, $this->url[1])){
                echo "method tidak ada";
            }
            
        }
        
        switch($length){
            case 4:
                $this->controller->{$this->url[1]}($this->url[2],$this->url[3]);
                break;
            case 3:
                $this->controller->{$this->url[1]}($this->url[2]);
                break;
            case 2:
                $this->controller->{$this->url[1]}();
                break;
            case 1:
                $this->controller->index();
                break;
            /*default :
                $controller->{$url[1]}($param);
                break;*/
            
                
        } 
    }
}

?>
