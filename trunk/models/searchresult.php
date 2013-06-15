<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SearchResult {
    private $id;
    private $tgl;
    private $nomor;
    private $hal;
    private $tipe;
    private $file;
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setTanggal($tanggal){
        $this->tgl = $tanggal;
    }
    
    public function setNomor($nomor){
        $this->nomor = $nomor;
    }
    
    public function setPerihal($hal){
        $this->hal = $hal;
    }
    
    public function setTipe($tipe){
        $this->tipe = $tipe;
    }
    
    public function setFile($file){
        $this->file = $file;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getTanggal(){
        return $this->tgl;
    }
    
    public function getNomor(){
        return $this->nomor;
    }
    
    public function getPerihal(){
        return $this->hal;
    }
    
    public function getTipe(){
        return $this->tipe;
    }
    
    public function getFile(){
        return $this->file;
    }
    
    public function __toString(){
        echo "Nomor : ".$this->getNomor()."</br>";
        echo "Tanggal : ".$this->getTanggal()."</br>";
        echo "Hal : ".$this->getPerihal()."</br></br>";
    }
}
?>
