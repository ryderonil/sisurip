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
    private $fileTo;
    private $ubahNama = array();
    private $fileEkst;
    
    public function __construct($fupload) {
        $this->init($fupload);
    }
    
    public function init($fupload){
        $this->setDirFrom($_FILES[$fupload]['tmp_name']);
        $this->setFileExt($_FILES[$fupload]['type']);
        $this->setFileName($_FILES[$fupload]['name']);        
//        echo $this->getDirFrom();
//        echo $this->getFileExt();
//        echo $this->getFileName();        
    }
    
    public function cekFileExist(){
        if(file_exists($this->getDirFrom())){
            return true;
        }else{
            return false;
        }
    }
    
    public function cekEkstensi($fileExt){
        //$this->setFileExt($fileExt);
        
        if($fileExt == __EXT_FILE__ OR $fileExt == 'application/msword' OR $fileExt == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
            return true;
        }else{
            return false;
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
        $ekst = end(explode(".", $filename));
        $nama = rtrim($nama, "_");
        //$nama .= $filename;
        $nama .= ".".$ekst;
        $nama = str_replace('/', '_', $nama); 
        $nama = trim($nama);
        $this->fileTo = $nama;
        return $this->fileTo;
    }
    
    /*
     * param => dirTo, dan nama input file
     */
    public function uploadFile(){           
        if($this->cekFileExist()){
            if($this->cekEkstensi($this->getFileExt())){
                move_uploaded_file($this->getDirFrom(), $this->getDirTo().$this->getFileTo());
                return true;
            }else{
//                throw new Exception();
                return false;
//                exit();
            }
        }else{
//            throw new Exception();
            return false;
//            exit();
        }
        
        //memindah file
        //echo $this->getDirFrom().'</br>';
        //echo $this->getDirTo().$this->getFileTo();
        //move_uploaded_file($this->getDirFrom(), $this->getDirTo().$this->getFileTo());
    }
    
    public static function renameFile($old,$new){
        rename($old, $new);
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
    
    public function setFileTo($filename){
        $this->fileTo = $filename;
    }
    
    public function getDirTo() {return $this->dirTo;}
    
    public function getDirFrom() {return $this->dirFrom;}
    
    public function getFileExt() {return $this->fileExt;}
    
    public function getFileName() {return $this->fileName;}
    
    public function getFileTo() {return $this->fileTo;}
}
?>
