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

}

?>
