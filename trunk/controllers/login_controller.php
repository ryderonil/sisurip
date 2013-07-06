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
        Session::createSession();
        if(isset($_SESSION['loggedin'])) {
            header('location:'.URL.'home');
        }else{
            $this->view->render('login/index');
        }
        
    }
    
    public function auth(){
        $user = new User();
        $username = $_POST['username'];
        $password = Hash::create('md5', $_POST['password'], HASH_SALT_KEY);
        $data = $user->getUser($username,$password);
        foreach($data as $value){
            $this->user = $value->get('nama_user');
            $this->nama = $value->get('namaPegawai');
            $this->role = $value->get('role'); 
            $this->bagian = $value->get('bagian'); 
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
            $log = new Log();
            $log->addLog(Session::get('user'),'LOGIN','');
            unset($log);
//            header('location:../home');
            echo json_encode(array(
                'status' => 'success'
            ));
        }else{
//            $this->view->error['invalid'] = 'Akun tidak ditemukan';
            //header('location:../login');
//            $this->view->render('login/index');
//            echo 'Akun tidak ditemukan';
            echo json_encode(array(
                'status' => 'error',
                'message'=> 'Akun tidak ditemukan'
            ));
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
        $log = new Log();
        $log->addLog($user,'CHANGE ROLE','user '.$user.' mengganti role/bagian ke '.Session::get('role').'/'.Session::get('bagian'));
        unset($log);
        header('location:'.URL.'suratmasuk');
    }


    public function logout(){
        //$this->model->logout();
        //Session::unsetAll();
        Session::createSession();
        $log = new Log();
        $log->addLog(Session::get('user'),'LOGOUT','');
        unset($log);
        Session::destroySession();
        //session_destroy();
        header('location:'.URL.'login');
        exit();
    }
    
    function __destruct() {
        ;
    }
    
}
?>
