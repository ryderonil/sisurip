<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function cekKantor(){
        $sth = $this->select("SELECT * FROM kantor");
        $count = count($sth);
        
        return $count;
    }
    
    public function updateKantor($table, $data, $where, $cek = true){
        
        if($cek==true){
           $this->update($table, $data, $where); 
        }else{
           $this->insert($table, $data);
        }      
        
    }
    
    public function selectTable($table){
        return $this->select("SELECT * FROM ".$table);
    }
    
    public function addPenomoran($data){
        $this->insert('nomor', $data);
    }
    
    public function updatePenomoran($data, $where){
        $this->update('nomor', $data, $where);
    }
    
    public function deleteNomor($where){
        $this->delete('nomor', $where);
    }
    
    public function addKlasifikasiArsip($data){
        $this->insert('klasifikasi_arsip', $data);
    }
    
    public function updateKlasifikasiArsip($data, $where){
        $this->update('klasifikasi_arsip', $data, $where);
    }
    
    public function deleteKlasifikasiArsip($where){
        $this->delete('klasifikasi_arsip', $where);
    }
    
    public function addLampiran($data){
        $this->insert('tipe_naskah', $data);
    }
    
    public function updateLampiran($data, $where){
        $this->update('tipe_naskah', $data, $where);
    }
    
    public function deleteLampiran($where){
        $this->delete('tipe_naskah', $where);
    }
    
    public function addStatusSurat($data){
        $this->insert('status', $data);
    }
    
    public function updateStatusSurat($data, $where){
        $this->update('status', $data, $where);
    }
    
    public function deleteStatusSurat($where){
        $this->delete('status', $where);
    }
    
    public function addUser($data){
        $this->insert('user', $data);
    }
    
    public function updateUser($data, $where){
        $this->update('user', $data, $where);
    }
    
    public function deleteUser($where){
        $this->delete('user', $where);
    }
    
    public function setAktifUser($id, $aktif){
        $data = array(
          'active'=>$aktif  
        );
        
        $where = ' id_user='.$id;
        $this->update('user', $data, $where);
    }
    
    public function addLokasi($data){
        $this->insert('lokasi', $data);
    }
    
    public function viewLokasi(){
        $data = array();
        $query = 'SELECT a.id_lokasi as id_lokasi, a.bagian, b.kd_bagian as bagian, a.lokasi as lokasi, a.status as status 
            FROM lokasi a JOIN r_bagian b ON a.bagian = b.kd_bagian WHERE a.tipe = 1';
        $rak = $this->select($query);
        $no = 1;
        foreach ($rak as $value){
            $data[] = array($no, $value['bagian'], $value['lokasi'],null,null,$value['status'],$value['id_lokasi']);
            $sql = 'SELECT * FROM lokasi WHERE parent='.$value['id_lokasi'];
            $baris = $this->select($sql);
            foreach ($baris as $value1){
                $data[] = array(null,null, null,$value1['lokasi'],null,$value1['status'],$value1['id_lokasi']);
                $sql1 = 'SELECT * FROM lokasi WHERE parent='.$value1['id_lokasi'];
                $box = $this->select($sql1);
                foreach ($box as $value2){
                    $data[] = array(null,null, null,null,$value2['lokasi'],$value2['status'],$value2['id_lokasi']);
                }
            }
            $no++;
        }
        return $data;
    }
    
    public function updateLokasi($data, $where){
        $this->update('lokasi', $data, $where);
    }
    
    public function setStatusLokasi($id, $status){
        //$status = ($status == 'PENUH')?'E':'F';
        $data = array(
          'status'=>$status
        );
        
        $where = ' id_lokasi='.$id;
        $this->update('lokasi', $data, $where);
    }
    
    public function getAlamat($kd=null){
        if(is_null($kd)) return $this->select('SELECT * FROM alamat');
        if(strlen($kd)>1){
            return $this->select('SELECT * FROM alamat WHERE kode_satker='.$kd);
        }
        return $this->select('SELECT * FROM alamat WHERE id_alamat='.$kd);
    }
    
    public function addAlamatSurat($data){
        $this->insert('alamat', $data);
    }
    
    public function updateAlamatSurat($data,$where){
        $this->update('alamat', $data, $where);
    }
    
    public function getBagianLain($user){
        $sql = "SELECT id_bagian, bagian FROM r_bagian WHERE id_bagian <> (SELECT bagian FROM user WHERE username='".$user."')";
        //echo $sql;
        return $this->select($sql);
    }
    
    public function getJabatan(){
        $sql = "SELECT id_jabatan, nama_jabatan FROM jabatan";
        return $this->select($sql);
    }
    
    public function getRole(){
        $sql = "SELECT id_role, role FROM role";
        return $this->select($sql);
    }
    
    public function cekPejabatLama($bagian, $jabatan){
        
        $sql = "SELECT * FROM user WHERE bagian=$bagian AND jabatan=$jabatan AND active='Y'";
        $data = count($this->select($sql));
        if($data>0){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function rekamPjs($data){
        $this->insert('pjs', $data);        
    }
    
    public function getPjs(){
        $sql = "SELECT a.id_pjs as id_pjs, 
            b.namaPegawai as user, 
            c.bagian as bagian, 
            d.role as jabatan
            FROM pjs a JOIN user b ON a.user = b.username
            JOIN r_bagian c ON a.bagian = c.id_bagian 
            JOIN role d ON a.jabatan = d.id_role";
        
        return $this->select($sql);
    }
    
    public function getNomor($bagian){
        $sql = "SELECT kd_nomor FROM nomor WHERE bagian='".$bagian."'";
        $datan = $this->select($sql);
        $nomor = '';
        foreach ($datan as $val){
            $nomor = $val['kd_nomor'];
        }
        
        return $nomor;
    }
   
}
?>
