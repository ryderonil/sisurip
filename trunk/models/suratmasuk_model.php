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
class Suratmasuk_Model extends Model{
    //put your code here
    var $lastId;
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
        
    }
    
    public function showAll(){
        
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
                FROM suratmasuk a JOIN alamat b 
                ON a.asal_surat = b.kode_satker
                ORDER BY a.id_suratmasuk DESC";
        
        return $this->select($sql);
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
    
    public function editSurat(){
        $data = array(
            "tgl_terima"=>$_POST['tgl_terima'],
            "tgl_surat"=>$_POST['tgl_surat'],
            "no_surat"=>$_POST['no_surat'],
            "asal_surat"=>$_POST['asal_surat'],
            "perihal"=>$_POST['perihal'],
            "status"=>$_POST['status'],
            "sifat"=>$_POST['sifat'],
            "jenis"=>$_POST['jenis'],
            "lampiran"=>$_POST['lampiran']
        );
        
        $id = $_POST['id'];
        $where = "id_suratmasuk = '".$id."'";
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


    public function getSuratMasukById($id){ //fungsi ini mgkn tidak diperlukan
        
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
