<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Kantor{
    
    
    public static function getNama(){
        $model = new Model();
        
        $kantor = $model->select('SELECT singkatan FROM kantor');
        foreach ($kantor as $data) {
             $kantor = $data['singkatan'];
        }
       
        return $kantor;
    }
}
?>
