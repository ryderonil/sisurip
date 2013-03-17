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
        
        echo '</br>';
    }
    
    function heading($heading, $hirarki){
        switch($hirarki){
           case 1:
               echo '<h1>'.$heading.'</h1>';
               break;
           case 2;
               echo '<h2>'.$heading.'</h2>';
               break;
           case 3;
               echo '<h3>'.$heading.'</h3>';
               break;
           case 4;
               echo '<h4>'.$heading.'</h4>';
               break;
        }
    }
    
    function img($param=array()){
        $img = '<img';
        foreach($param as $key=>$value){
            $img .= ' '.$key.'='.$value;
        }
        
        $img .= '>';
        echo $img;
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
            echo $nbs;
        }
        
        echo '&nbsp';
    }
    
    function hr(){
        echo "<hr>";
    }
    
    function div_open($id, $ids){
        echo "<div $id='".$ids."'>";
    }
    
    function div_close(){
        echo "</div>";
    }
}
?>
