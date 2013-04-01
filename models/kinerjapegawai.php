<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KinerjaPegawai extends Model{
    
    private $batasWaktuSurat;
    private $suratMulai;
    private $suratSelesai;
    private $user;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function set($attr, $value){
        switch($attr){
            case 'batasWaktuSurat':
                $this->batasWaktuSurat = $value;
                break;
            case 'suratMulai':
                $this->suratMulai = $value;
                break;
            case 'suratSelesai':
                $this->suratSelesai = $value;
                break;
            case 'user':
                $this->user = $value;
                break;
        }
    }
    
    public function get($attr){
        switch($attr){
            case 'batasWaktuSurat':
                return $this->batasWaktuSurat;
                break;
            case 'suratMulai':
                return $this->suratMulai;
                break;
            case 'suratSelesai':
                return $this->suratSelesai;
                break;
            case 'user':
                return $this->user;
                break;
        }
    }
    
    public function calculateKinerja($this){
        
    }
    
    public function displayKinerja(){
        
    }
    
    
}
?>
