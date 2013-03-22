<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Helper_Controller extends Controller{

    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->view->kantor = Kantor::getNama(); 
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }

    /* public function alamat() {
      $keyword = $_POST['asal_surat'];
      $data = array();
      $data['response'] = false;
      $query = $this->model->lookup($keyword);
      if(!empty($query)){
      $data['response']=true;
      $data['message']=array();
      foreach($query as $row){
      $data['message'][] = array(
      'kode_satker'=>$row['kode_satker'],
      'nama_satker'=>$row['nama_satker'],
      ''
      );
      }
      }

      if('IS_AJAX'){
      echo json_encode($data);
      }else{
      $this->view->render('suratmasuk/rekam');
      }

      mysql_connect('localhost', 'root', '') or die('$&^%*%$^#&^%');
      mysql_select_db('sisurip');

      $q = $_REQUEST['term'];
      if (!$q)
      return;


      $sql = mysql_query("SELECT kode_satker, nama_satker FROM alamat WHERE nama_satker LIKE '%$q%'");
      $result = array();
      while ($r = mysql_fetch_array($sql)) {
      //$satker = $r['kode_satker'] . ' ' . $r['nama_satker'];
      //echo "$satker \n";
      $results[] = array('nama_satker' => $row['nama_satker']);
      }

      echo json_encode($results);
      } */

    function alamat() {
        $q = $_POST['queryString'];              

        $dblink = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('sisurip');
        
        $rs = mysql_query("SELECT kode_satker, nama_satker FROM alamat WHERE nama_satker LIKE '%$q%'", $dblink);

        //$data = array();
        if ($rs && mysql_num_rows($rs)) {
            while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                //$data[] = array(
                    //'label' => $row['kode_satker'].' '.$row['nama_satker'],
                    //'value' => $row['kode_satker']
                    //
                //);
                
                echo '<a href=#>'.$row['kode_satker'].' '.$row['nama_satker'].'</a></br>';
            }
        }

        //echo json_encode($data);
        //flush();
    }
    
    function pilihbaris(){
        $q = $_POST['queryString'];              

        $dblink = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('sisurip');
        
        $rs = mysql_query("SELECT * FROM lokasi WHERE parent ='".$q."' and tipe=2", $dblink);
        echo "<option value=>--PILIH BARIS--</option>";
        if ($rs && mysql_num_rows($rs)) {
            
            while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                echo "<option value='".$row['id_lokasi']."'>$row[lokasi]</option>";
            }
        }
        
        
    }
    
    function pilihbox(){
        $q = $_POST['queryString'];              

        $dblink = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('sisurip');
        
        $rs = mysql_query("SELECT * FROM lokasi WHERE parent ='".$q."'", $dblink);
        echo "<option value=>--PILIH BOX--</option>";
        if ($rs && mysql_num_rows($rs)) {
            
            while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                echo "<option value='".$row['id_lokasi']."'>$row[lokasi]</option>";
            }
        }
    }
    
    function pilihrak(){
        $q = $_POST['queryString'];              

        $dblink = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('sisurip');
        
        $rs = mysql_query("SELECT * FROM lokasi WHERE bagian ='".$q."' AND tipe=1", $dblink);
        echo "<option value=>--PILIH FILLING/RAK--</option>";
        if ($rs && mysql_num_rows($rs)) {
            
            while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                echo "<option value='".$row['id_lokasi']."'>$row[lokasi]</option>";
            }
        }
    }
    
    function pilihalamat($var, $id=null){
        if((int)$var==1){
            $this->view->surat = 'suratmasuk/rekam';
        }elseif((int)$var==2){
            $this->view->surat = 'suratkeluar/rekam';
        }elseif((int)$var==3){
            $this->view->surat = 'suratmasuk/edit';
            
        }
        
        if(!is_null($id)) $this->view->ids = $id;
        //echo $this->view->surat;
        //$this->view->kdsurat = $var;
        $this->view->alamat = $this->model->getAlamat();  
        //var_dump($this->view->alamat)   ; 
        $this->view->render('helper/alamat');
    }

}

?>
