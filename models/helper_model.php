<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Helper_Model extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function lookup($keyword){
        echo $keyword;
        $sql = "SELECT kode_satker, nama_satker FROM alamat WHERE nama_satker LIKE '%$keyword%'";
        
        return $this->select($sql);
    }
    
    function getAlamat(){
        $admin = new Admin_Model();
        return $admin->getAlamat();
    }
    
    function getKodeSatker($data=null){
        $config = array('host'=>DB_HOST,
                        'db_name'=>DB_NAME_KPPN,
                        'pass'=>DB_PASS,
                        'port'=>DB_PORT_KPPN,
                        'user'=>DB_USER);
        
        $con = new Koneksi();
        $pdo = $con->getConnection($config);
        $sql = "SELECT kdsatker,nmsatker FROM t_satker LIMIT 0,30";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        unset($con);
        return $data;
    }
    
    static function getRoleName($id){
        $model = new Model();
        $sql = "SELECT role FROM role WHERE id_role=".$id;
        $drole = $model->select($sql);
        foreach ($drole as $val){
            return $val['role'];
        }
    }
    
    static function getBagianName($id){
        $model = new Model();
        $sql = "SELECT bagian FROM r_bagian WHERE id_bagian=".$id;
        $dbag = $model->select($sql);
        foreach ($dbag as $val){
            return $val['bagian'];
        }
    }
    
    static function getRoleUser($user){
        $model = new Model();
        $sql = "SELECT role, bagian FROM user WHERE username='".$user."'";        
        $duser = $model->select($sql);
        $i=0;
        $roleuser = array();
        foreach ($duser as $val){
            $roleuser[$i][0]=$val['role'];
            $roleuser[$i][1]=$val['bagian'];
            $dbag = $model->select("SELECT bagian FROM r_bagian WHERE id_bagian=".$val['bagian']);
            $bag = '';
            foreach ($dbag as $value){
                $bag = $value['bagian'];
            } 
            if($val['role']==2 AND $val['bagian']==1){
                $roleuser[$i][2] = 'Kasubag Umum';
            }else if($val['role']==2 AND $val['bagian']!=1){
                $roleuser[$i][2] = 'Kasi '.$bag;
            }else if($val['role']==1){
                $roleuser[$i][2] = 'Kepala Kantor';
            }else if($val['role']==3){
                $roleuser[$i][2] = 'Pelaksana '.$bag;
            }else if($val['role']==4){
                $roleuser[$i][2] = 'Sekretaris Kepala Kantor';
            }else if($val['role']==5){
                $roleuser[$i][2] = 'Petugas Adm Surat';
            }
            $i++;
        }
        $sql = "SELECT jabatan, bagian FROM pjs WHERE user='".$user."'";
        $dpjs = $model->select($sql);
        foreach ($dpjs as $val){
            $roleuser[$i][0]=$val['jabatan'];
            $roleuser[$i][1]=$val['bagian'];
            $dbag = $model->select("SELECT bagian FROM r_bagian WHERE id_bagian=".$val['bagian']);
            $bag = '';
            foreach ($dbag as $value){
                $bag = $value['bagian'];
            } 
            if($val['jabatan']==2 AND $val['bagian']==1){
                $roleuser[$i][2] = 'Kasubag Umum';
            }else if($val['jabatan']==2 AND $val['bagian']!=1){
                $roleuser[$i][2] = 'Kasi '.$bag;
            }else if($val['jabatan']==1){
                $roleuser[$i][2] = 'Kepala Kantor';
            }else if($val['jabatan']==3){
                $roleuser[$i][2] = 'Pelaksana '.$bag;
            }else if($val['jabatan']==4){
                $roleuser[$i][2] = 'Sekretaris Kepala Kantor';
            }else if($val['jabatan']==5){
                $roleuser[$i][2] = 'Petugas Adm Surat';
            }
            $i++;
        }
        
        return $roleuser;
    }
    
    function __destruct() {
        ;
    }
    
}
?>
