<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of suratmasuk_model
 *
 * @author aisyah
 */
class Suratmasuk_Model extends Surat{
    //put your code here
    var $lastId;
    private $id_suratmasuk;
    private $tgl_terima;
    private $no_agenda;
    
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
        
    }
    
    public function setTglTerima($value){
        $this->tgl_terima = $value;
    }
    
    public function getTglTerima(){
        return $this->tgl_terima;
    }
    
    public function setAgenda($value){
        $this->no_agenda = $value;
    }
    
    public function getAgenda(){
        return $this->no_agenda;
    }

    public function showAll($limit=null,$batas=null){
        
        //$sql = "SELECT * FROM suratmasuk";
        $sql = "SELECT a.id_suratmasuk as id_suratmasuk,
                a.no_agenda as no_agenda,
                a.no_surat as no_surat,
                a.tgl_terima as tgl_terima,
                a.tgl_surat as tgl_surat,
                b.nama_satker as asal_surat,
                a.perihal as perihal,
                a.status as status,
                a.sifat as sifat,
                a.jenis as jenis,
                a.lampiran as lampiran,
                a.start as start,
                a.end as end
                FROM suratmasuk a LEFT JOIN alamat b 
                ON a.asal_surat = b.kode_satker
                ORDER BY a.id_suratmasuk DESC";
        if(!is_null($limit) AND !is_null($batas)){
            $sql .= " LIMIT $limit,$batas";
        }
        
        $data = $this->select($sql);
        $surat = array();
        foreach ($data as $value){
            $obj = new $this;
            $obj->setAlamat($value['asal_surat']);
            $obj->setId($value['id_suratmasuk']);
            $obj->setJenis($value['jenis']);
            $obj->setJmlLampiran($value['lampiran']);
            $obj->setNomor($value['no_surat']);
            $obj->setPerihal($value['perihal']);
            $obj->setSifat($value['sifat']);
            $obj->setTglSurat($value['tgl_surat']);
            $obj->setTglTerima($value['tgl_terima']);
            $obj->setAgenda($value['no_agenda']);
            $surat[] = $obj;
        }
//        var_dump($surat);
        return $data;
    }
    
    public function remove($id){
        $where = 'id_suratmasuk='.$id;
        $this->delete('suratmasuk', $where);
        header('location:'.URL.'suratmasuk');
    }
    
    public function input($data){
        
        //var_dump($data);
        $insert = $this->insert('suratmasuk', $data);
        if($insert){
            //$this->lastId = $this->lastInsertId(); //mengembalikan nilai yg benar klo dipanggil sebelum commit()
            return true;
        }
        
        return false;
    }
    
    public function editSurat($data,$where){
        
        //echo $where;
        return $this->update("suratmasuk", $data, $where);
//        header('location:'.URL.'suratmasuk');
        
    }
    
    public function lastIdInsert(){
        $sql = "SELECT MAX(id_suratmasuk) as id FROM suratmasuk";
        $data = $this->select($sql);
        
        foreach ($data as $val){
            $this->lastId = $val['id'];
        }
        
        return $this->lastId;
        
    }


    public function getSuratById($id){ //fungsi ini mgkn tidak diperlukan
        
        return $this->select("SELECT * FROM suratmasuk WHERE id_suratmasuk=:id", array("id"=>$id));
    }
    
    public function get($table){
        return $this->select("SELECT * FROM ".$table);
    }
    
    public function rekamdisposisi($data){ 
        $insert = $this->insert('disposisi', $data);
        if($insert){
            return true;
        }                
        return false;
        
    }
    
    public function distribusi($id, $data){
        $length = count($data);
        for($i=0;$i<$length;$i++){
            $dataInsert = array(
                'id_surat'=>$id,
                'id_bagian'=>$data[$i]
            );
            //var_dump($dataInsert);
            $this->insert('distribusi', $dataInsert);
        }
    }
    
    public function uploadFile($data,$where){
    
        $this->update('suratmasuk', $data, $where);
    }
}

?>
