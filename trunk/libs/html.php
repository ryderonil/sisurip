<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Html{
    
    public function __construct() {
        ;
    }
    
    function br($baris=null){
        if(!is_null($baris)){
            $br = '';
            for($i=0;$i<$baris;$i++){
                $br .= '</br>';
            }
            return $br;
        }
        
        return '</br>';
    }
    
    function heading($heading, $hirarki){
        switch($hirarki){
           case 1:
               return '<h1>'.$heading.'</h1>';
               break;
           case 2;
               return '<h2>'.$heading.'</h2>';
               break;
           case 3;
               return '<h3>'.$heading.'</h3>';
               break;
           case 4;
               return '<h4>'.$heading.'</h4>';
               break;
        }
    }
    
    function img($param=array()){
        $img = '<img';
        foreach($param as $key=>$value){
            $img .= ' '.$key.'='.$value;
        }
        
        $img .= '>';
        return $img;
    }
    
    function link_tag($link=array()){
        
    }
    
    function meta(){
        
    }
    
    function nbs($nbs=null){
        if(!is_null($nbs)){
            $nbs = '';
            for($i=0;$i<$nbs;$i++){
                $nbs .= '&nbsp;';
            }
            return $nbs;
        }
        
        return '&nbsp';
    }
}
?>
