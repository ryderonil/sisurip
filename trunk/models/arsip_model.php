<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Arsip_Model extends Model {

    //put your code here
    
    var $id_arsip;
    var $id_surat;
    var $kode_arsip;
    var $klas;
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }
    
    public function emptyNomor($no){
        if($no==''){
            return true;
        }
        
        return false;
    }


    public function getSurat($id, $surat){
        switch($surat){
            case 'SM':
                $sm = new Suratmasuk_Model();
                return $sm->getSuratMasukById($id);
                break;
            case 'SK':
                $sk=new Suratkeluar_Model();
                return $sk->getSuratKeluarById($id, 'ubah');
                break;
            
        }
    }
    
    public function rekamArsip($data){
        return $this->insert('arsip', $data);
    }
    
    public function getKlas(){
        $sql = "SELECT * FROM klasifikasi_arsip";
        return $this->select($sql);
    }

    public function getRak(){
        $sql = "SELECT * FROM lokasi WHERE tipe=1";
        return $this->select($sql);
    }
    
    public function getBaris($parent=null){
        if(!is_null($parent)){
            $sql = "SELECT * FROM lokasi WHERE tipe=2 AND parent=".$parent;
        }else{
            $sql = "SELECT * FROM lokasi WHERE tipe=2";
        }
        
        return $this->select($sql);
    }
    
    public function getBox($parent=null){
        if(!is_null($parent)){
            $sql = "SELECT * FROM lokasi WHERE tipe=3 AND parent=".$parent;
        }else{
            $sql = "SELECT * FROM lokasi WHERE tipe=3";
        }
        
        return $this->select($sql);
    }
    
    public function getArsip($id, $tipe){
        $sql = "SELECT a.id_lokasi as id_lokasi,
                b.id_lokasi as box,
                c.id_lokasi as baris,
                d.id_lokasi as rak,
                a.jenis as klas
                FROM arsip a LEFT JOIN lokasi b ON a.id_lokasi = b.id_lokasi
                LEFT JOIN lokasi c ON b.parent = c.id_lokasi
                LEFT JOIN lokasi d ON c.parent = d.id_lokasi
                WHERE a.id_surat=".$id." AND a.tipe_surat='".$tipe."'";
        
        $data = $this->select($sql);
        return $data;
    }
}
?>
