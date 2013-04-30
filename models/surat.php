<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Surat extends Model{
    
    private $id_surat;
    private $alamat;
    private $file;
    private $nomor;
    private $perihal;
    private $sifat;
    private $jenis;
    private $tgl_surat;
    private $jml_lampiran;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function setId($value){
        $this->id_surat = $value;
    }
    
    public function getId(){
        return $this->id_surat;
    }
    
    public function setAlamat($value){
        $this->alamat = $value;
    }
    
    public function setFile($value){
        $this->file = $value;
    }
    
    public function setNomor($value){
        $this->nomor = $value;
    }
    
    public function setPerihal($value){
        $this->perihal = $value;
    }
    
    public function setSifat($value){
        $this->sifat = $value;
    }
    
    public function setJenis($value){
        $this->jenis = $value;
    }
    
    public function setTglSurat($value){
        $this->tgl_surat = $value;
    }
    
    public function setJmlLampiran($value){
        $this->jml_lampiran = $value;
    }
    
    public function getAlamat(){
        return $this->alamat;
    }
    
    public function getFile(){
        return $this->file;
    }
    
    public function getNomor(){
        return $this->nomor;
    }
    
    public function getPerihal(){
        return $this->perihal;
    }
    
    public function getSifat(){
        return $this->sifat;
    }
    
    public function getJenis(){
        return $this->jenis;
    }
    
    public function getTglSurat(){
        return $this->tgl_surat;
    }
    
    public function getJmlLampiran(){
        return $this->jml_lampiran;
    }
    
    abstract protected function input($data);
    
    abstract protected function remove($id);
    
    abstract protected function editSurat($data,$where);
    
    abstract protected function showAll();
    
    abstract protected function getSuratById($id);
    
    abstract protected function uploadFile($data,$where);
    
}
?>
