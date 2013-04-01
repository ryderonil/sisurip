<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CatatanKasie extends Model{
    
    
    private $catatan;
    private $id_surat;
    private $userPejabat;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function set($attr, $val){
        switch ($attr){
            case 'catatan':
                $this->catatan = $val;
                break;
            case 'id_surat':
                $this->id_surat = $val;
                break;
            case 'userPejabat':
                $this->userPejabat = $val;
                break;
        }
    }

    public function get($attr){
        switch ($attr){
            case 'catatan':
                return $this->catatan;
                break;
            case 'id_surat':
                return $this->id_surat;
                break;
            case 'userPejabat':
                return $this->userPejabat;
                break;
        }
    }

    public function add(){
        
    }
    
    public function delete($id){
        
    }
    
    public function getCatatan($id){
        
    }
    
    public function getKasie(){
        return;
    }
    
    public function getSurat(){
        return;
    }
    
    

}
?>
