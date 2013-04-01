<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class IkhtisharArsip extends Model{
    
    private $id_arsip;
    private $id_surat; //jenis surat/sm atau sk
    private $lokasi;
    private $nomor_surat;
    private $perihal;
    private $diarsipkan; //tgl
            
    
    public function __construct() {
        parent::__construct();
    }
    
    public function set($attr, $value){
        switch ($attr){
            case 'id_arsip':
                $this->id_arsip = $value;
                break;
            case 'id_surat':
                $this->id_surat = $value;
                break;
            case 'lokasi':
                $this->lokasi = $value;
                break;
            case 'nomor_surat':
                $this->nomor_surat = $value;
                break;
            case 'perihal':
                $this->perihal = $value;
                break;
            case 'diarsipkan':
                $this->diarsipkan = $value;
                break;
        }
    }
    
    public function get($attr){
        switch ($attr){
            case 'id_arsip':
                return $this->id_arsip;
                break;
            case 'id_surat':
                return $this->id_surat;
                break;
            case 'lokasi':
                return $this->lokasi;
                break;
            case 'nomor_surat':
                return $this->nomor_surat;
                break;
            case 'perihal':
                return $this->perihal;
                break;
            case 'diarsipkan':
                return $this->diarsipkan;
                break;
        }
    }
    
    public function generateIkhtisharArsip(){
        
    }
    
    public function getArsipByKlasifikasi($klas){
        $sql = "SELECT * FROM arsip WHERE klasifikasi=".$klas;        
    }
    
    public function getArsipbyLokasi($lokasi){
        $sql = "SELECT * FROM arsip WHERE lokasi=".$lokasi;
    }
    
    
}
?>
