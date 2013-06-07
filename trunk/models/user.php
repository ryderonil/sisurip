<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends Model{
    
    private $id_user;
    private $namaPegawai;
    private $NIP;
    private $nama_user;
    private $password;
    private $bagian;
    private $jabatan;
    private $role;
    private $active;
    
    /*
     * constructor
     */
    public function __construct() {
        @parent::__construct();
    }
    
    /*
     * setter
     */
    public function set($attr, $value){
        switch($attr){
            case 'id_user':
                $this->id_user = $value;
                break;
            case 'namaPegawai':
                $this->namaPegawai = $value;
                break;
            case 'NIP':
                $this->NIP = $value;
                break;
            case 'nama_user':
                $this->nama_user = $value;
                break;
            case 'password':
                $this->password = $value;
                break;
            case 'bagian':
                $this->bagian = $value;
                break;
            case 'jabatan':
                $this->jabatan = $value;
                break;
            case 'role':
                $this->role = $value;
                break;
            case 'active':
                $this->active = $value;
                break;
            default:
                //throw new Exception();
                echo "default";
                break;
                
                    
        }
    }
    
    /*
     * getter
     */
    public function get($attr){
        switch($attr){
            case 'id_user':
                return $this->id_user;
                break;
            case 'namaPegawai':
                return $this->namaPegawai;
                break;
            case 'NIP':
                return $this->NIP;
                break;
            case 'nama_user':
                return $this->nama_user;
                break;
            case 'password':
                return $this->password;
                break;
            case 'bagian':
                return $this->bagian;
                break;
            case 'jabatan':
                return $this->jabatan;
                break;
            case 'role':
                return $this->role;
                break;
            case 'active':
                return $this->active;
                break;
            default:
                echo "default";
                break;
                
                    
        }
    }
    
    /*
     * fungsi menambah user ke database, tabel user
     * return boolean true
     */
    public function addUser(){
        $data = array(
            'namaPegawai' => $this->get('namaPegawai'),
            'NIP' => $this->get('NIP'),
            'username' => $this->get('nama_user'),
            'password' => Hash::create('md5', $this->get('password'), HASH_SALT_KEY),
            'bagian' => $this->get('bagian'),
            'jabatan' => $this->get('jabatan'),
            'role' => $this->get('role'),
            'active' => $this->get('active')
        );
        return $this->insert('user', $data);
    }
    
    /*
     * fungsi edit data user
     * return boolean true
     */
    public function editUser(){
        $data = array(
            'namaPegawai' => $this->get('namaPegawai'),
            'NIP' => $this->get('NIP'),
            'username' => $this->get('nama_user'),
            'password' => $this->get('password'),
            'bagian' => $this->get('bagian'),
            'jabatan' => $this->get('jabatan'),
            'role' => $this->get('role'),
            'active' => $this->get('active')
        );
        $where = ' id_user=' . $this->get('id_user');
        return $this->update('user', $data, $where);
    }
    
    /*
     * fungsi hapus user
     * return boolean
     */
    
    public function hapusUser(){
        $where = ' id_user='.$this->get('id_user');
        return $this->delete('user', $where);
    }
    
    /*
     * fungsi pengaturan aktif user
     * return boolean
     */
    public function setAktifUser(){
        $data = array(
          'active'=>$this->get('active')  
        );
        
        $where = ' id_user='.$this->get('id_user');
        return $this->update('user', $data, $where);
    }

    /*
     * fungsi mendapatkan data user
     * return data array user
     */ 
    public function getUser($id=NULL,$password=NULL){
        //belum selesai
        $data = null;
//        echo is_int($id);
        if(is_null($id)){
//            echo '1';
            $data = $this->select('SELECT * FROM user');
        }  elseif(is_int($id) AND is_null($password)) {
//            echo '2';
            $data = $this->select('SELECT * FROM user WHERE id_user='.$id);
        }elseif(!is_int($id) AND !is_null($password)){
//            echo '3';
            $data = $this->select("SELECT * FROM user WHERE username='".$id."' AND password='". $password."' AND active='Y'");
        }
        $return = array();
        foreach ($data as $val){
            $user = new $this;
            $user->set('id_user',$val['id_user']);
            $user->set('namaPegawai',$val['namaPegawai']);
            $user->set('NIP',$val['NIP']);
            $user->set('nama_user',$val['username']);
            $user->set('password',$val['password']);
            $user->set('bagian',$val['bagian']);
            $user->set('jabatan',$val['jabatan']);
            $user->set('role',$val['role']);
            $user->set('active',$val['active']);
            $return[]= $user;
        }
        
        return $return;
    }
    
    /*
     * fungsi cek ketersediaan user di database, table user
     * @param nama user, NIP
     * return boolean false jika tidak ditemukan
     * return pesan kesalahan jika ditemukan
     */
    public function cekUserExist($username, $NIP){
        $sql = "SELECT * FROM user WHERE username LIKE '".$username."'";
        $data = $this->select($sql);
        $i = count($data);
        if($i>0){
            return true;
        }
        
        $sql = "SELECT * FROM user WHERE NIP='".$NIP."'";
        $data = $this->select($sql);
        $i = count($data);
        if($i>0){
            return true;
        }
        
        return false;
        
    }
    
    public static function getIdUser($username){
        $return = 0;
        $model = new Model();
        $sql = "SELECT id_user FROM user WHERE username='".$username."'";
//        print_r($sql);
        $data = $model->select($sql);
        foreach ($data as $val){
            $return = $val['id_user'];
        }
        
        return $return; 
    }
    
    
    
    
    
}
?>
