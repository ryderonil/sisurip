<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function cekKantor(){
        $sth = $this->select("SELECT * FROM kantor");
        $count = count($sth);
        
        return $count;
    }
    
    public function updateKantor($table, $data, $where, $cek = true){
        
        if($cek==true){
           $this->update($table, $data, $where); 
        }else{
           $this->insert($table, $data);
        }      
        
    }
    
    public function selectTable($table){
        return $this->select("SELECT * FROM ".$table);
    }
    
    public function addPenomoran($data){
        $this->insert('nomor', $data);
    }
    
    public function updatePenomoran($data, $where){
        $this->update('nomor', $data, $where);
    }
    
    public function deleteNomor($where){
        $this->delete('nomor', $where);
    }
    
    public function addKlasifikasiArsip($data){
        $this->insert('klasifikasi_arsip', $data);
    }
    
    public function updateKlasifikasiArsip($data, $where){
        $this->update('klasifikasi_arsip', $data, $where);
    }
    
    public function deleteKlasifikasiArsip($where){
        $this->delete('klasifikasi_arsip', $where);
    }
    
    public function addLampiran($data){
        $this->insert('lampiran', $data);
    }
    
    public function updateLampiran($data, $where){
        $this->update('lampiran', $data, $where);
    }
    
    public function deleteLampiran($where){
        $this->delete('lampiran', $where);
    }
    
    public function addStatusSurat($data){
        $this->insert('status', $data);
    }
    
    public function updateStatusSurat($data, $where){
        $this->update('status', $data, $where);
    }
    
    public function deleteStatusSurat($where){
        $this->delete('status', $where);
    }
    
    public function addUser($data){
        $this->insert('user', $data);
    }
    
    public function updateUser($data, $where){
        $this->update('user', $data, $where);
    }
    
    public function deleteUser($where){
        $this->delete('user', $where);
    }
    
    public function setAktifUser($id, $aktif){
        $data = array(
          'active'=>$aktif  
        );
        
        $where = ' id_user='.$id;
        $this->update('user', $data, $where);
    }
}
?>
