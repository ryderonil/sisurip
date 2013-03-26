<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Login_Model extends Model {

    //put your code here

    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }

    public function auth($username, $password) {

        $sql = "SELECT * FROM user WHERE username = :username AND password = :password AND active='Y'";
        $sth = $this->prepare($sql);

        $sth->bindValue(":username", $username);
        $sth->bindValue(":password", $password);

        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        //$int = $sth->rowCount();
        //if($int>0) return true;
        //return false;
        return $data;
    }

    public static function getRoleName($id) {

        $role = '';
        $sql = 'SELECT role FROM role WHERE id_role=:id';
        $pdo = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id',$id);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_OBJ);
        foreach ($data as $value) {
            $role = $value->role;
        }
        return $role;
    }

    public static function getBagianName($id) {
        $bagian = '';
        $sql = 'SELECT bagian FROM r_bagian WHERE id_bagian=' . $id;
        $pdo = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id',$id);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_OBJ);
        foreach ($data as $value) {
            $bagian = $value->bagian;
        }

        return $bagian;
    }
    

}

?>
