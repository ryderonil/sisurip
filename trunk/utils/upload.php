<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Upload{
    
    private $dirTo;
    private $dirFrom;
    private $fileExt;
    private $fileName;
    private $ubahNama = array();
    
    public function __construct() {
        
    }
    
    public function init($fupload){
        $this->setDirFrom($_FILES[$fupload]['tmp_name']);
        $this->setFileExt($_FILES[$fupload]['type']);
        $this->setFileName($_FILES[$fupload]['name']);
    }
    
    public function cekFileExist(){
        if(file_exists($this->getDirFrom())){
            return true;
        }else{
            return false;
        }
    }
    
    public function cekEkstensi($fileExt){
        $this->setFileExt($fileExt);
        
        if($this->getFileExt() != __EXT_FILE__){
            return false;
        }else{
            return true;
        }
    }
    
    public function getFile(){
        
    }
    
    /*
     * @param ubahNama=>array, jenis surat-nomor surat-satker-tgl surat
     * mungkin bisa dihapus, dengan set get langsung aja untuk menggantikannya
     */
    public function changeFileName($filename, $ubahNama){
        $nama = '';
        $length = count($ubahNama);
        for($i=0;$i<$length;$i++){
            $nama .= $ubahNama[$i]."_";
        }
        
        $nama .= $filename;
        $nama = trim($nama);
        
        return $nama;
    }
    
    /*
     * param => dirTo, dan nama input file
     */
    public function uploadFile(){           
        $this->cekFileExist();
        $this->cekEkstensi($this->getFileExt());
        //memindah file
        move_uploaded_file($this->getDirFrom(), $this->getDirTo());
    }   
     
    public function setDirTo($dirTo){
        $this->dirTo = $dirTo;
    }
    
    public function setDirFrom($dirFrom){
        $this->dirFrom = $dirFrom;
    }
    
    public function setFileExt($fileExt){
        $this->fileExt = $fileExt;
    }
    
    public function setFileName($fileName){
        $this->fileName = $fileName;
    }
    
    public function setUbahNama($ubahNama){
        $this->ubahNama = $ubahNama;
    }
    
    public function getDirTo() {return $this->dirTo;}
    
    public function getDirFrom() {return $this->dirFrom;}
    
    public function getFileExt() {return $this->fileExt;}
    
    public function getFileName() {return $this->fileName;}
    
    public function getUbahNama() {return $this->ubahNama;}
}
?>
