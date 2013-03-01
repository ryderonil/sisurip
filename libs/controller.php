<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author aisyah
 */
class Controller {
    
    //$registry;
    protected $model;
    protected $registry;
    
    public function __construct($registry) {
        //echo "ini adalah class base controller</br>";
        $this->view = new View();
        $this->registry = $registry;
    }
    
    public function loadModel($model){
        $file = 'models/'.$model.'_model.php';
        //echo $file;
        
        if(file_exists($file)){
            require $file;
            
            $model = ucfirst($model).'_Model';
            
            $this->model = new $model;
        }else{
            echo 'model tidak ada';
        }
    }
    
}

?>
