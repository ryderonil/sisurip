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
            return "<form action='".URL.$action."'";
            
        }
        
        $form_open = "<form action='".URL.$action."'";
        foreach ($form as $key=>$value){
            $form_open .= " ".$key."='".$value."'";
        }
        $form_open .= ">";
        
        return $form_open;
    }
    
    function form_close(){
        return "</form>";
    }
    
    function form_input($input = array()){
        $type = "text";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        return $return;
        
    }
    
    function form_hidden($input = array()){
        $type = "hidden";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        return $return;
    }
    
    function form_password($input=array()){
        $type = "password";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        return $return;
    }
    
    function form_upload($input=array()){
        $type = "file";
        $return = "<input type='".$type."'";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= "/>";
        
        return $return;
    }
    
    function form_textarea($input=array(), $val=null){
        $return = "<textarea";
        
        foreach($input as $key=>$value){
            $return .= " ".$key."='".$value."'";
        }
        
        $return .= ">".$val."</textarea>";
        
        return $return;
    }
    
    function form_label($Name, $for=null){
        if(!is_null($for)){
            return '<label>'.$Name.'</label>';
        }
        
        return "<label for='".$for."'>".$Name."</label>";
    }
    
    function form_dropdown($name, $option, $selected=0){
        $return = "<select name='".$name."'>";
        
        foreach($option as $key=>$value){
            if($key==$selected) $return .= "<option value='".$key."' selected>'".$value."'</option>";
            $return .= "<option value='".$key."'>'".$value."'</option>";
        }
        
        $return .= "</select>";
        return $return;
    }
    
    function form_checkbox($name, $value){
        $type = 'checkbox';
        return "<input type='".$type."' name='".$name."' value='".$value."'/>";
    }
    
    function form_radio($name, $value){
        $type = 'radio';
        return "<input type='".$type."' name='".$name."' value='".$value."'/>";
    }
    
    function form_submit($name,$value){
        $type='submit';
        return "<input type='".$type."' name='".$name."' value='".$value."'/>";
    }
    
    function form_button($name, $value){
        $type='button';
        return "<button type='".$type."' name='".$name."'>'".$value."'</button>";
    }
    
    function form_reset($name, $value){
        $type='reset';
        return "<input type='".$type."' name='".$name."' value='".$value."'/>";
    }
    
    
}
?>
