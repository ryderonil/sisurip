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
    
    public function __construct() {
        @parent::__construct();
    }
    
    public function __set($attr, $value){
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
    
    public function __get($attr){
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
    
    public function addUser($data){
        $this->insert('user', $data);
    }
    
    public function editUser($data, $where){
        $this->update('user', $data, $where);
    }
    
    public function getRole(){
        //belum selesai
        return $this->role;
    }
    
    public function getUser(){
        //belum selesai
        $data = $this->select('SELECT * FROM user');
        return $data;
    }
    
    public function getUserById($user){
        $data = $this->select('SELECT * FROM user WHERE id_user='.$user->id_user);
    }
    
    public function cekUserExist($username, $NIP){
        
    }
    
    
    
    
    
}
?>
