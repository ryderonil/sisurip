<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cari_Model extends Model{
    
    var $filter;
    var $keyword;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findLampiran($keyword){
        $sql = "SELECT id_lamp, tanggal, nomor, hal, file FROM lampiran WHERE hal LIKE '%$keyword%'";
        $data = $this->select($sql);
        
        $result = array();
        $int = 0;
        foreach ($data as $val){
            $result[$int][0] = $val['id_lamp'];
            $result[$int][1] = $val['tanggal'];
            $result[$int][2] = $val['nomor'];
            $result[$int][3] = $val['hal'];
            $int++;
        }
        return $result;
    }
    
    public function findSuratMasuk($keyword){
        $sql = "SELECT id_suratmasuk, tgl_surat, no_surat, perihal, file FROM suratmasuk WHERE perihal LIKE '%$keyword%'";
        $data = $this->select($sql);
        $result = array();
        $int = 0;
        foreach ($data as $val){
            $result[$int][0] = $val['id_suratmasuk'];
            $result[$int][1] = $val['tgl_surat'];
            $result[$int][2] = $val['no_surat'];
            $result[$int][3] = $val['perihal'];
            $int++;
        }
        return $result;
    }
    
    public function findSuratKeluar($keyword){
        $sql = "SELECT id_suratkeluar, tgl_surat, no_surat, perihal, file FROM suratkeluar WHERE perihal LIKE '%$keyword%'";
        $data = $this->select($sql);
        $result = array();
        $int = 0;
        foreach ($data as $val){
            $result[$int][0] = $val['id_suratkeluar'];
            $result[$int][1] = $val['tgl_surat'];
            $result[$int][2] = $val['no_surat'];
            $result[$int][3] = $val['perihal'];
            $int++;
        }
        return $result;
    }
    
    public function findByDate($start, $until){
        
    }
    
    public function splitKeyword($keyword){
        $array = explode(" ", $keyword);
        //cek apakah array 0 merupakan filter
        $filter = $array[0];
        if(explode(":",$filter)){
            $filter=  explode(":", $array[0]);
            @$this->filter = $filter[1];
            @$this->keyword = $array[1];
        }else{
            $this->filter='all';
            $this->keyword = $array[0];
            
        }
        
    }
    
    
}
?>
