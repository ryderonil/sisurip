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
    
    public function __construct($registry) {
        //echo "</br>ini adalah bootstrap";
        $this->registry = $registry;
        
    }
    
    public function init(){
        $url = isset($_GET['page'])?$_GET['page']:null;
        //print_r($url);
        
        
        $url = rtrim($url, "/");
        $url = explode('/',$url);
        //print_r($url);
        //isset($url[0])?$url[0]:null;
        
        if(isset($url[0])){
            $file = 'controllers/'.$url[0].'_controller.php';
            
            if(file_exists($file)){
                //require $file;
                
                $classController = ucfirst($url[0]).'_Controller';
                //echo $classController;
                $controller = new $classController;
                
                $controller->loadModel($url[0]);
            }else{
                $controller = new Suratmasuk_Controller;
                //echo "file ".$url[0].'.php tidak ada';
                $controller->loadModel('suratmasuk');
            }
        }
        
        /*if(isset($url[1])){
            if(method_exists($controller, $url[1])):
               $controller->{$url[1]}();
            else:
               $controller->index();
               //header('location:'.URL);
            endif;
        }else{
            $controller->index();
        }*/
        
        $param = array();
        
        $length = count($url);
        if($length>2){
            for($i=2;$i<$length;$i++){
                $param[] = $url[$i];
            }
        }
        
        $param = implode(",",$param);
        //echo $param;
        
        if($length>1){
            if(!method_exists($controller, $url[1])){
                echo "method tidak ada";
            }
            
        }
        
        switch($length){
            case 4:
                $controller->{$url[1]}($url[2],$url[3]);
                break;
            case 2:
                $controller->{$url[1]}();
                break;
            case 1:
                $controller->index();
                break;
            default :
                $controller->{$url[1]}($param);
                break;
            
                
        }
        
       
    }
}

?>
