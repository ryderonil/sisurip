<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Login_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        $this->view->kantor = Kantor::getNama(); 
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
        $this->view->js = array(
          'login/js/default'  
        );
    }
    //put your code here
    
    public function index(){
        $this->view->render('login/index');
    }
    
    public function auth(){
        $user = new User();
        $username = $_POST['username'];
        $password = Hash::create('md5', $_POST['password'], HASH_SALT_KEY);
        //$password = $_POST['password'];
//        $data = $this->model->auth($username, $password);
        $data = $user->getUser($username,$password);
        foreach($data as $value){
            $this->user = $value['username'];
            $this->nama = $value['namaPegawai'];
            $this->role = $value['role']; 
            $this->bagian = $value['bagian']; 
        }
        
        $int = count($data);
        $this->view->error=array();
        if($int>0){
            @Session::createSession();
            Session::set('loggedin',true);
            Session::set('user', $this->user);
            Session::set('nama',$this->nama);
            Session::set('role',$this->role);
            Session::set('bagian', $this->bagian);
            header('location:../suratmasuk');
        }else{
            $this->view->error['invalid'] = 'Akun tidak ditemukan';
            //header('location:../login');
            $this->view->render('login/index');
        }
    }
    
    public function changeRole($role){        
        Session::createSession();
        $user = Session::get('user');
        $nama = Session::get('nama');        
        $role = explode("-", $role);
        
        Session::destroySession();        
        Session::createSession();
        Session::set('loggedin',true);
        Session::set('user', $user);
        Session::set('nama',$nama);
        Session::set('role',$role[0]);
        Session::set('bagian', $role[1]);        
        header('location:'.URL.'suratmasuk');
    }


    public function logout(){
        //$this->model->logout();
        //Session::unsetAll();
        Session::createSession();
        Session::destroySession();
        //session_destroy();
        header('location:'.URL.'login');
        exit();
    }
    
}
?>
