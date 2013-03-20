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
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
        
    }
    
    public function showAll(){
        
        $sql = "SELECT * FROM suratmasuk";        
        
        return $this->select($sql);
    }
    
    public function remove($id){
        $where = 'id_suratmasuk='.$id;
        $this->delete('suratmasuk', $where);
        header('location:'.URL.'suratmasuk');
    }
    
    public function input(){
        $tglagenda = date('Y-m-d');
        $asal = trim($_POST['asal_surat']);
        $asal = explode(' ', $asal);
        $data = array(
            "no_agenda"=>$_POST['no_agenda'],
            "tgl_terima"=> $tglagenda,
            "tgl_surat"=>  Tanggal::ubahFormatTanggal($_POST['tgl_surat']),
            "no_surat"=>$_POST['no_surat'],
            "asal_surat"=>$asal[0],
            "perihal"=>$_POST['perihal']
            //"status"=>$_POST['status'],
            //"sifat"=>$_POST['sifat'],
            //"jenis"=>$_POST['jenis'],
            //"lampiran"=>$_POST['lampiran']
        );
        //var_dump($data);
        $this->insert('suratmasuk', $data);
        header('location:'.URL.'suratmasuk');
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
        $this->update("suratmasuk", $data, $where);
        header('location:'.URL.'suratmasuk');
    }
    
    public function getSuratMasukById($id){ //fungsi ini mgkn tidak diperlukan
        
        return $this->select("SELECT * FROM suratmasuk WHERE id_suratmasuk=:id", array("id"=>$id));
    }
    
    public function get($table){
        return $this->select("SELECT * FROM ".$table);
    }
    
    public function rekamdisposisi(){
        $id_surat = $_POST['id_surat'];
        $sifat = $_POST['sifat'];
        $petunjuk = $_POST['petunjuk'];
        $catatan = $_POST['catatan'];
        $disposisi = $_POST['disposisi'];
        $disp = implode(',',$disposisi);
        $petunjuk = implode(',',$petunjuk);
        
        $data = array(
            'id_surat'=>$id_surat,
            'sifat'=>$sifat,
            'disposisi'=>$disp,
            'petunjuk'=>$petunjuk,
            'catatan'=>$catatan
            );
        
        $this->insert('disposisi', $data);        
        $this->distribusi($id_surat, $disposisi);
        header('location:'.URL.'suratmasuk');
    }
    
    public function distribusi($id, $data){
        $length = count($data);
        for($i=0;$i<$length;$i++){
            $dataInsert = array(
                'id_surat'=>$id,
                'id_bagian'=>$data[$i]
            );
            $this->insert('distribusi', $dataInsert);
        }
    }
}

?>
