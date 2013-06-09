<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getDataAdminById($id, $tipe){
        switch($tipe){
            case 'lampiran':
                return $this->select('SELECT * FROM tipe_naskah WHERE id_tipe=' . $id);
                break;
            case 'user':
                break;
            case 'lokasi':
                break;
            case 'alamat':
                break;
            case 'klasarsip':
                break;
            case 'nomor':
                break;
        }
    }
    public function cekKantor(){
        $sth = $this->select("SELECT * FROM kantor");
        $count = count($sth);
        
        return $count;
    }
    
    public function updateKantor($table, $data, $where, $cek = true){
        
        if($cek==true){
           return $this->update($table, $data, $where); 
        }else{
           return $this->insert($table, $data);
        }      
        
    }
    
    public function selectTable($table){
        return $this->select("SELECT * FROM ".$table);
    }
    
    public function addPenomoran($data){
        return $this->insert('nomor', $data);
    }
    
    public function updatePenomoran($data, $where){
        return $this->update('nomor', $data, $where);
    }
    
    public function deleteNomor($id){
        $where = ' id_nomor=' . $id;
        return $this->delete('nomor', $where);
    }
    
    public function addKlasifikasiArsip($data){
        return $this->insert('klasifikasi_arsip', $data);
    }
    
    public function updateKlasifikasiArsip($data, $where){
        return $this->update('klasifikasi_arsip', $data, $where);
    }
    
    public function deleteKlasifikasiArsip($id){
        $where = ' id_klasarsip=' . $id;
        $this->delete('klasifikasi_arsip', $where);
        return true;
    }
    
    public function addLampiran($data){
        return $this->insert('tipe_naskah', $data);
    }
    
    public function updateLampiran($data, $where){
        return $this->update('tipe_naskah', $data, $where);
    }
    
    /*
     * ubah status lampiran menjadi aktif dan tidak aktif
     * return boolean
     */
    public function deleteLampiran($where){
        /*$data = array(
          'status'=>$status
        );
        
        $where = ' id_lokasi='.$id;
        return $this->update('lokasi', $data, $where);*/
        return $this->delete('tipe_naskah', $where);
    }
    
    public function addStatusSurat($data){
        return $this->insert('status', $data);
    }
    
    public function updateStatusSurat($data, $where){
        return $this->update('status', $data, $where);
    }
    
    public function deleteStatusSurat($where){
        $this->delete('status', $where);
    }
    
    public function addUser($data){
        return $this->insert('user', $data);
    }
    
    public function updateUser($data, $where){
        return $this->update('user', $data, $where);
    }
    
    public function deleteUser($where){
        
        $this->delete('user', $where);
    }
    
    public function setAktifUser($id, $aktif){
        $data = array(
          'active'=>$aktif  
        );
        
        $where = ' id_user='.$id;
        return $this->update('user', $data, $where);
    }
    
    public function addLokasi($data){
        return $this->insert('lokasi', $data);
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
        return $this->update('lokasi', $data, $where);
    }
    
    public function setStatusLokasi($id, $status){
        //$status = ($status == 'PENUH')?'E':'F';
        $data = array(
          'status'=>$status
        );
        
        $where = ' id_lokasi='.$id;
        return $this->update('lokasi', $data, $where);
    }
    
    public function getAlamat($kd=null){
        if(is_null($kd)) return $this->select('SELECT * FROM alamat');
        if(strlen($kd)>1){
            return $this->select('SELECT * FROM alamat WHERE kode_satker='.$kd);
        }
        return $this->select('SELECT * FROM alamat WHERE id_alamat='.$kd);
    }
    
    public function addAlamatSurat($data){
        return $this->insert('alamat', $data);
    }
    
    public function updateAlamatSurat($data,$where){
        return $this->update('alamat', $data, $where);
    }
    
    public function existAlamat($satker){
        $sql = "SELECT * FROM alamat WHERE kode_satker=:satker";
        $array = array('satker'=>$satker);
        $data = $this->select($sql, $array);
        if(count($data)>0){
            return true;
        }
        return false;
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
    
    public function cekPjs($bagian, $jabatan){
        
        $sql = "SELECT * FROM pjs WHERE bagian=$bagian AND jabatan=$jabatan ";
        $data = count($this->select($sql));
        if($data>0){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function rekamPjs($data){
        return $this->insert('pjs', $data);        
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
    
    public function cekLibur($tgl){
        $sql = "SELECT * FROM libur WHERE tgl='".$tgl."'";
        $data = $this->select($sql);
        if(count($data)>0){
            foreach ($data as $val){
                $ket = $val['keterangan'];
                return $ket;
            }
        }else{
            return false;
        }
    }
    
    public function getLibur(){
        $sql = "SELECT * FROM libur";
        $data = $this->select($sql);
        return $data;
    }
    
    public function rekamLibur($data){
        return $this->insert('libur', $data);
    }
    
    public function updateLibur($data){
        $where = " tgl='".$data['tgl']."'";
        return $this->update('libur',$data,$where);
    }
    
    public function deleteLibur($tgl){
        $where = " tgl='".$tgl."'";
        return $this->delete('libur',$where);
    }
    
    public function getKlasifikasiById($id){
        return $this->select('SELECT * FROM klasifikasi_arsip WHERE id_klasarsip=' . $id);
    }
    
    public function getLokasiById($id){
        return $this->select('SELECT * FROM lokasi WHERE id_lokasi=' . $id);
    }
    
    public function getNomorById($id){
        return $this->select('SELECT * FROM nomor WHERE id_nomor=' . $id);
    }
    
    public static function getJabatanUser($jabatan, $bagian=null){
        $model = new Admin_Model;
        $return = '';
        if($jabatan==6){
            $sql = "SELECT bagian FROM r_bagian WHERE id_bagian=".$bagian;
            $data = $model->select($sql);
            foreach($data as $val){
                $return = 'Pelaksana '.$val['bagian'];
            }
        }else{
            $sql = "SELECT nama_jabatan FROM jabatan WHERE id_jabatan=".$jabatan;
            $data = $model->select($sql);
            foreach($data as $val){
                $return = $val['nama_jabatan'];
            }
        }
        
        return $return;
    }
    
    function __destruct() {
        ;
    }
   
}
?>
