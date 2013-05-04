<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Disposisi extends Model{
    
    private $id_disposisi;
    private $id_surat;
    private $sifat;
    private $dist;
    private $petunjuk;
    private $catatan;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function __set($name, $value){
        switch($name){
            case 'id_disposisi':
                $this->id_disposisi = $value;
                break;
            case 'id_surat':
                $this->id_surat = $value;
                break;
            case 'sifat':
                $this->sifat = $value;
                break;
            case 'distribusi':
                $this->dist = $value;
                break;
            case 'petunjuk':
                $this->petunjuk = $value;
                break;
            case 'catatan':
                $this->catatan = $value;
                break;
            default:
                echo 'not valid attribute';
                break;
        }
    }
    
    public function __get($name){
        switch($name){
            case 'id_disposisi':
                return $this->id_disposisi;
                break;
            case 'id_surat':
                return $this->id_surat;
                break;
            case 'sifat':
                return $this->sifat;
                break;
            case 'dist':
                return $this->dist;
                break;
            case 'petunjuk':
                return $this->petunjuk;
                break;
            case 'catatan':
                return $this->catatan;
                break;
            default:
                echo 'not valid attribute';
                break;
        }
    }
    
    public function addDisposisiKasi($data){
        $this->insert('catatan', $data);
    }
    
    public function getDisposisi($data=array()){
        $sql ='';
        foreach($data as $key=>$value){
            
            if($key=='id_disposisi'){
                $sql = 'SELECT * FROM disposisi WHERE id_disposisi='.$value;
            }elseif ($key=='id_surat') {
                $sql = 'SELECT * FROM disposisi WHERE id_surat='.$value;
            }
        }
        $disp = $this->select($sql);
        if(count($disp)>0){
            foreach($disp as $value){
                $this->id_disposisi = $value['id_disposisi'];
                $this->id_surat = $value['id_surat'];
                $this->sifat = $value['sifat'];
                $this->petunjuk = explode(',', trim($value['petunjuk']));
                $this->dist = explode(',',trim($value['disposisi']));
                $this->catatan = $value['catatan'];
            }
        }else{
            $this->id_disposisi = null;
                $this->id_surat = null;
                $this->sifat = null;
                $this->petunjuk = null;
                $this->dist = null;
                $this->catatan = null;
        }       
        
        return $this;
    }
    
    public function printDisposisi(){
        
    }
    
    public function addDisposisi($data){
        $insert = $this->insert('disposisi', $data);
        return $insert;
    }
    
    public function __destruct() {
        ;
    }
}
?>
