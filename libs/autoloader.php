<?php


//class Autoloader{
    
    //$path = array();
    
    function __autoload($class){
        $path = array(
                'controllers/',
                'models/',
                'libs/'
            );
        $file = strtolower($class).'.php';
        //echo $file;
        $length = sizeof($path);
        for($i=0;$i<$length;$i++){
            //echo $path[$i];
            $filepath = $path[$i].$file;
            //echo $filepath;
            if(file_exists($filepath)){                
                require $filepath;
                //echo 'file ada';
                return true;
            }
        }
        
        echo 'file tidak ada';
        return false;        
    }
    
    function setPath($path){
        $path = $path;
    }
//}
?>
