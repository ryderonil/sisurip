<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Form_Generator{
    
    public function __construct() {
        ;
    }
    
    function form_open($action, $form=array()){
        if(!is_null($form)){
            echo "<form action='".URL.$action."'>";
            
        }
        
        $form_open = "<form action='".URL.$action."'";
        foreach ($form as $key=>$value){
            $form_open .= " ".$key."='".$value."'";
        }
        $form_open .= ">";
        
        echo $form_open;
    }
    
    function form_close(){
        echo "</form>";
    }
    
    function form_input($input = array()){
        $type = "text";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        echo $return;
        
    }
    
    function form_hidden($input = array()){
        $type = "hidden";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        echo $return;
    }
    
    function form_password($input=array()){
        $type = "password";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        echo $return;
    }
    
    function form_upload($input=array()){
        $type = "file";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        echo $return;
    }
    
    function form_textarea($input=array(), $val=null){
        $return = "<textarea";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= ">".$val."</textarea>";
        
        echo $return;
    }
    
    function form_label($Name, $for=null){
        if(!is_null($for)){
            return '<label>'.$Name.'</label>';
        }
        
        echo "<label for='".$for."'>".$Name."</label>";
    }
    
    function form_dropdown($name, $option, $selected=0){
        $return = "<select name='".$name."'>";
        
        foreach($option as $key=>$value){
            if($key==$selected) $return .= "<option value='".$key."' selected>'".$value."'</option>";
            $return .= "<option value='".$key."'>'".$value."'</option>";
        }
        
        $return .= "</select>";
        echo $return;
    }
    
    function form_checkbox($name, $value){
        $type = 'checkbox';
        echo "<input type='".$type."' name='".$name."' value='".$value."'>";
    }
    
    function form_radio($name, $value){
        $type = 'radio';
        echo "<input type='".$type."' name='".$name."' value='".$value."'>";
    }
    
    function form_submit($name,$value){
        $type='submit';
        echo "<input type='".$type."' name='".$name."' value='".$value."'>";
    }
    
    function form_button($name, $value){
        $type='button';
        echo "<button type='".$type."' name='".$name."'>'".$value."'</button>";
    }
    
    function form_reset($name, $value){
        $type='reset';
        echo "<input type='".$type."' name='".$name."' value='".$value."'>";
    }
    
    
}
?>
