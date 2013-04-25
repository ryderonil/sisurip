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

    function alamat() {
        $q = $_POST['queryString'];
        $q = explode(",", $q);
        

        $dblink = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('sisurip');
        
        $rs = mysql_query("SELECT kode_satker, nama_satker FROM alamat WHERE nama_satker LIKE '%$q[0]%'", $dblink);

        //$data = array();
        if ($rs && mysql_num_rows($rs)) {
            echo "<table class='CSSTableGenerator'>
                    <tr><th>No</th><th>Kode Satker</th><th>Nama Satker</th><th>Pilih</th></tr>";           
            $no=1;
            while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                echo "<tr>
               <td>$no</td> 
               <td>$row[kode_satker]</td>
               <td>$row[nama_satker]</td>";
                if (isset($this->ids)) {            
                    echo "<td><a href=" . URL . $q[1] . "/" . $row['kode_satker'] . "/" . $this->ids . ">
                        <input class=btn type=button value=PILIH onclick=pilih($row[kode_satker]);></a></td>";
                } else {
                    echo "<td><a href=" . URL . $q[1] . "/" . $row['kode_satker'] . ">
                        <input class=btn type=button value=PILIH onclick=pilih($row[kode_satker]);></a></td>";
                }
                echo "</tr>";
                $no++;
            }
            
            echo "</table>";
        }

        //echo json_encode($data);
        //flush();
    }
    
    function cekalamat() {
        $q = $_POST['queryString'];              

        $dblink = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('sisurip');
        
        $rs = mysql_query("SELECT kode_satker, nama_satker FROM alamat WHERE kode_satker LIKE '%$q%' ", $dblink);

        //$data = array();
        if ($rs && mysql_num_rows($rs)) {
            $no=1;
            while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                if($no==1){
                    echo "<input type=text name=nmsatker value='".$row['nama_satker']."'></br>";
                }else{
                    echo "<label></label><input type=text name=nmsatker value='".$row['nama_satker']."'></br>";
                }
                
                //echo '<a href=#>'.$row['kode_satker'].' '.$row['nama_satker'].'</a></br>';
                $no++;
            }
        }

       
    }
    
    function pilihbaris(){ //selesai
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
    
    function pilihbox(){ //selesai
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
    
    function pilihrak(){ //selesai
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
    
    function pilihalamat($var, $id=null){ //selesai
        if((int)$var==1){
            $this->view->surat = 'suratmasuk/rekam';
        }elseif((int)$var==2){
            $this->view->surat = 'suratkeluar/rekam';
        }elseif((int)$var==3){
            $this->view->surat = 'suratmasuk/edit';
            
        }elseif((int)$var==4){
            $this->view->surat = 'suratkeluar/edit';
            
        }
        
        if(!is_null($id)) $this->view->ids = $id;
        //echo $this->view->surat;
        //$this->view->kdsurat = $var;
        $this->view->alamat = $this->model->getAlamat();  
        //var_dump($this->view->alamat)   ; 
        $this->view->render('helper/alamat');
    }
    
    function pilihkppn(){
        $q = $_POST['queryString'];              

        $dblink = mysql_connect('localhost', 'root', '') or die(mysql_error());
        mysql_select_db('sisurip');
        
        $rs = mysql_query("SELECT * FROM t_kppn WHERE kdkanwil='".$q."'", $dblink);
        echo "<option value=>-- PILIH KPPN --</option>";
        if ($rs && mysql_num_rows($rs)) {
            
            while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                echo "<option value='".$row['kdkppn']."'>Kantor Pelayanan Perbendaharaan Negara $row[nmkppn]</option>";
            }
        }
    }
    
    function pilihsatker($id=null){
        if(!is_null($id)) {
            $this->view->id=$id;
        }
        //var_dump($this->view->id);
        $this->view->data = $this->model->getKodeSatker();
        $this->view->lokasi = $this->model->select("SELECT * FROM t_lokasi");
        $this->view->dept = $this->model->select("SELECT * FROM t_dept");
        $this->view->kab = $this->model->select("SELECT * FROM t_kabkota");
        $this->view->render('helper/pilihsatker');
    }
    
    function lookupSatker(){
        $filter = $_POST['queryString'];
        $fil = explode(',', $filter);
        //$length = strlen($filter);
        //if($length==2){
        //    $sql="SELECT kdsatker,nmsatker FROM t_satker WHERE kdlokasi=".$filter;
        //}else{
        //    $sql="SELECT kdsatker,nmsatker FROM t_satker WHERE kddept=".$filter;
        //}
        
        $sql="SELECT kdsatker,nmsatker FROM t_satker WHERE kdkabkota=".$fil[0]." AND kdlokasi=".$fil[1];
        $data = $this->model->select($sql);
        $no=1;
        echo "<tr><td>NO</td>
                    <td>KODE</td>
                    <td>NAMA SATKER</td>
                    <td>AKSI</td></tr>";
        foreach($data as $value){
            echo "<tr><td>$no</td>
                    <td>$value[kdsatker]</td>
                    <td>$value[nmsatker]</td>";
            if(isset($fil[2])){
                echo "<td><a href=".URL."admin/ubahAlamat/$fil[2]/$value[kdsatker]><input id=btn type=button value=PILIH></a></td></tr>";
            }else{
                echo "<td><a href=".URL."admin/rekamAlamat/$value[kdsatker]><input id=btn type=button value=PILIH></a></td></tr>";
            }
                    
            $no++;
        }
    }
    
    function lookupSatker2(){
        $filter = $_POST['queryString'];
        $filter=explode(',',$filter);        
        //if($filter[1]!=''){
            $sql="SELECT kdsatker,nmsatker FROM t_satker WHERE kdlokasi=".$filter[1]." AND kddept=".$filter[0];
        //}else{
            //$sql="SELECT kdsatker,nmsatker FROM t_satker WHERE kddept=".$filter[0];
        //}
        
        $data = $this->model->select($sql);
        $no=1;
        echo "<tr><td>NO</td>
                    <td>KODE</td>
                    <td>NAMA SATKER</td>
                    <td>AKSI</td></tr>";
        foreach($data as $value){
            echo "<tr><td>$no</td>
                    <td>$value[kdsatker]</td>
                    <td>$value[nmsatker]</td>
                    <td><a href=".URL."admin/rekamAlamat/$value[kdsatker]><input id=btn type=button value=PILIH></a></td></tr>";
            $no++;
        }
    }
    
    function lookupkab(){
        $filter = $_POST['queryString'];        
            $sql="SELECT kdkabkota,nmkabkota FROM t_kabkota WHERE kdlokasi=".$filter;
        
        
        $data = $this->model->select($sql);
        $no=1;        
        foreach($data as $value){
            echo "<option value=$value[kdkabkota]>$value[nmkabkota]</option>";
            $no++;
        }
    }
    
    function notif($user){
        //$sm = new Suratmasuk_Model();
        //$sk = new Suratkeluar_Model();
        $notif = new Notifikasi();
        $id_user = 0;
        $sql = "SELECT id_user FROM user WHERE username=:user";
        $param = array(':user'=>$user);
        $data = $this->model->select($sql, $param);
        //var_dump($data);
        foreach($data as $val){
            $id_user = $val['id_user'];
        }
        //echo $id_user;
        $sql = "SELECT id_notif, id_surat, jenis_surat FROM notifikasi WHERE id_user=:id_user AND stat_notif=1";
        $param = array(':id_user'=>$id_user);
        $data = $this->model->select($sql, $param);
        $this->view->jmlnotif = count($data);
        //var_dump($data);
        $notifsm = array();
        $notifsk=array();
        $id_notif = array();
        foreach ($data as $val){
            if($val['jenis_surat']=='SM'){
                $sql = "SELECT * FROM suratmasuk WHERE id_suratmasuk=:id_surat"; //ambil dari suratmasuk model
                $param= array(':id_surat'=>$val['id_surat']);
                $notifsm[]=$this->model->select($sql,$param);
                //$notifsm = $sm->getSuratMasukById($val['id_surat']);
                $id_notif[]=$val['id_notif'];
                $notif->set('id_notif', $val['id_notif']);
                $notif->set('stat_notif', 0);
                $notif->setNotif();
            }elseif($val['jenis_surat']=='SK'){
                $sql = "SELECT * FROM suratkeluar WHERE id_suratkeluar=:id_surat"; //ambil dari suratmasuk model
                $param= array(':id_surat'=>$val['id_surat']);
                $notifsk[]=$this->model->select($sql,$param);
                //$notifsk = $sk->getSuratKeluarById($val['id_surat'],'detil');
                $id_notif[]=$val['id_notif'];
                $notif->set('id_notif', $val['id_notif']);
                $notif->set('stat_notif', 0);
                $notif->setNotif();
            }
        }
        
        //var_dump($id_notif);
        
        
        $this->view->notifsm = $notifsm;
        $this->view->notifsk = $notifsk;
        //var_dump($notifsm);
        $this->view->render('notifikasi/notifikasi');
    }

}

?>
