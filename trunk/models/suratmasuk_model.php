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
    private $status_surat;
    private $start;
    private $end;
    
    
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
    
    public function setStatusSurat($value){
        $this->status_surat = $value;
    }
    
    public function getStatusSurat(){
        return $this->status_surat;
    }
    
    public function setStart($value){
        $this->start = $value;
    }
    
    public function getStart(){
        return $this->start;
    }
    
    public function setEnd($value){
        $this->end = $value;
    }
    
    public function getEnd(){
        return $this->end;
    }

    public function showAll($limit=null,$batas=null){
        @Session::createSession();
        $role = Session::get('role');
        $bagian = Session::get('bagian');
        $user = Session::get('user');
        if((Auth::isRole($role, 2) AND !Auth::isBagian($bagian, 1) ) OR (Auth::isRole($role, 3) )){
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
                LEFT JOIN notifikasi c ON a.id_suratmasuk = c.id_surat
                WHERE c.jenis_surat='SM' AND id_user=".User::getIdUser($user)."
                ORDER BY a.id_suratmasuk DESC";
        }else{
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
        }
        //$sql = "SELECT * FROM suratmasuk";
        
        if(!is_null($limit) AND !is_null($batas)){
            $sql .= " LIMIT $limit,$batas";
        }
//        print_r($sql);
        $data = $this->select($sql); //ntar dihapus
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
        return $surat;
    }
    
    public function remove($id=null){
        if(!is_null($id)){
            $where = 'id_suratmasuk='.$id;
        }else{
            $where = 'id_suratmasuk='.$this->getId();
        }
        
        $this->delete('suratmasuk', $where);
        
    }
    
    public function input($data=null){
        
        //var_dump($data);
        if(!is_null($data)){
            $insert = $this->insert('suratmasuk', $data);
        }else{
            $data = array(
                'no_agenda'=>$this->getAgenda(),
                'tgl_terima'=>$this->getTglTerima(),
                'tgl_surat'=>$this->getTglSurat(),
                'no_surat'=>$this->getNomor(),
                'asal_surat'=>$this->getAlamat(),
                'perihal'=>$this->getPerihal(),
                'sifat'=>$this->getSifat(),
                'jenis'=>$this->getJenis(),
                'status'=>$this->getStatusSurat(),
                'lampiran'=>$this->getJmlLampiran(),
                'stat'=>$this->getStatus(),
                'start'=>$this->getStart()
            );
        }
        
        if($insert){
            //$this->lastId = $this->lastInsertId(); //mengembalikan nilai yg benar klo dipanggil sebelum commit()
            return true;
        }
        
        return false;
    }
    
    public function editSurat($data=null,$where=null){
        if(is_null($data) AND is_null($where)){
            
            $data = array(
                "tgl_terima"=>$this->getTglTerima(),
                "tgl_surat"=>$this->getTglSurat(),
                "no_surat"=>$this->getNomor(),
                "asal_surat"=>$this->getAlamat(),
                "perihal"=>$this->getPerihal(),
                "status"=>$this->getStatusSurat(),
                "sifat"=>$this->getSifat(),
                "jenis"=>$this->getJenis(),
                "lampiran"=>$this->getJmlLampiran()
            );
            
            $where = "id_suratmasuk = '".$this->getId()."'";
            return $this->update("suratmasuk", $data, $where);
        }else{
            return $this->update("suratmasuk", $data, $where);
        }
        
        //echo $where;
        
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


    public function getSuratById($id=null){ //fungsi ini mgkn tidak diperlukan
        $data = null;
        if(!is_null($id)){
            if(is_array($id)){
                $key = key($id);
                $data = $this->select("SELECT * FROM suratmasuk WHERE $key='".$id[$key]."'");
//                var_dump("SELECT * FROM suratmasuk WHERE $key=$id[$key]");
            }else{
                $data = $this->select("SELECT * FROM suratmasuk WHERE id_suratmasuk=:id", array("id"=>$id));
            }
            
        }else{
            $data = $this->select("SELECT * FROM suratmasuk WHERE id_suratmasuk=:id", array("id"=>$this->getId()));
        }
//        var_dump($data);
        foreach ($data as $val){
            $this->setId($val['id_suratmasuk']);
//            var_dump($this->getId());
            $this->setAgenda($val['no_agenda']);
            $this->setTglTerima($val['tgl_terima']);
            $this->setTglSurat($val['tgl_surat']);
            $this->setNomor($val['no_surat']);
            $this->setAlamat($val['asal_surat']);
            $this->setPerihal($val['perihal']);
            $this->setSifat($val['sifat']);
            $this->setJenis($val['jenis']);
            $this->setStatusSurat($val['status']);
            $this->setJmlLampiran($val['lampiran']);
            $this->setStatus($val['stat']);
            $this->setFile($val['file']);
            $this->setStart($val['start']);
            $this->setEnd($val['end']);
        }
        return $this;
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
        if(!is_array($data)) $data = explode (",", $data);
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
    
    public function getNomorAgenda($id){
        $return = '';
        $sql = "SELECT no_agenda FROM suratmasuk WHERE id_suratmasuk=".$id;
        $data = $this->select($sql);
        foreach ($data as $val){
            $return = $val['no_agenda'];
        }
        
        return $return;
    }


    public function __destruct() {
        ;
    }
}

?>
