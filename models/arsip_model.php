<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Arsip_Model extends Model {

    //put your code here

    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }
    
    public function getSurat($id, $surat){
        switch($surat){
            
        }
    }
    
    public function rekamArsip($data){
        $this->insert('arsip', $data);
    }


    public function getRak(){
        $sql = "SELECT * FROM lokasi WHERE tipe=1";
        return $this->select($sql);
    }
    
    public function getBaris(){
        $sql = "SELECT * FROM lokasi WHERE tipe=2";
        return $this->select($sql);
    }
    
    public function getBox(){
        $sql = "SELECT * FROM lokasi WHERE tipe=3";
        return $this->select($sql);
    }
}
?>
