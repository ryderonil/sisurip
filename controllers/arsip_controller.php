<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Arsip_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->nomor = new Nomor();
        $this->view->kantor = Kantor::getNama(); 
        $this->view->js = array(
          'suratmasuk/js/default'  
        );
    }
    
    public function rekam($id,$tipesurat=null){
        if(!Auth::isAllow(3, Session::get('role'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->rekamArsip()){
                $this->view->success="Rekam arsip berhasil";
            }else{
                $this->view->error = "Rekam arsip gagal!";
            }
        }
             
        if(!is_null($tipesurat)){
            $this->view->tipe=$tipesurat;
            
            if($tipesurat=='SM'){
                $data = $this->model->getSurat($id,'SM');
                    $this->view->data[0] = $data->getId();
                    $this->view->data[1] = $data->getNomor();
                    $admin = new Admin_Model();
                    $alamat = $admin->getAlamat($data->getAlamat());
                    foreach ($alamat as $val){
                        $alamat = $val['nama_satker'];
                    }
                    $this->view->data[2] = $alamat;
                    $this->view->data[3] = $data->getPerihal();
                    $this->view->isAllow = $this->model->isAllowWrite($data->getId(),'SM');
            }elseif (($tipesurat=='SK')) {
                $data = $this->model->getSurat($id,'SK');
                    $this->view->data[0] = $data->getId();
                    $this->view->data[1] = $data->getNomor();
                    $admin = new Admin_Model();
                    $alamat = $admin->getAlamat($data->getAlamat());
                    foreach ($alamat as $val){
                        $alamat = $val['nama_satker'];
                    }
                    $this->view->data[2] = $alamat;
                    $this->view->data[3] = $data->getPerihal();
                    $this->view->isAllow = $this->model->isAllowWrite($data->getId(),'SK');
            }
        }
        
        $dataa = $this->model->getArsip($id, $tipesurat);
        if($dataa->id_arsip>0){             
                $this->view->ar['rak'] = $dataa->lokasi[1];
                $this->view->ar['baris'] = $dataa->lokasi[2];
                $this->view->ar['box'] = $dataa->lokasi[3];
                $this->view->ar['klas'] = $dataa->klas;
                $this->view->ar['id_arsip'] = $dataa->id_arsip;
            $this->view->rak = $this->model->getRak(true);
            $this->view->baris = $this->model->getBaris($this->view->ar['rak'],true);
            $this->view->box = $this->model->getBox($this->view->ar['baris'],true);
            $this->view->klas = $this->model->getKlas();
            
        }else{
            if($this->model->emptyNomor($this->view->data[1])){
                $this->view->warning = 'surat belum mendapat nomor surat, tidak dapat diarsipkan';
            }
            $this->view->rak = $this->model->getRak();
            $this->view->baris = $this->model->getBaris();
            $this->view->box = $this->model->getBox();
            $this->view->klas = $this->model->getKlas();            
        }
        
        
        $this->view->render('arsip/rekam');
    }
    
    public function rekamArsip(){
        
        $id_lokasi = $_POST['box'];
        $id_surat = $_POST['id'];
        $tipe_surat = $_POST['tipe'];
        $jenis = $_POST['jenis'];
        
        $data = array(
            'id_lokasi'=>$id_lokasi,
            'id_surat'=>$id_surat,
            'tipe_surat'=>$tipe_surat,
            'jenis'=>$jenis
        );
        
        if($this->model->rekamArsip($data)){
            $this->view->success = "Data arsip telah berhasil disimpan";
            $mon = new Monitoring_Model();
            $time = $mon->cekNextDay(date('Y-m-d h:m:s'),true);
            if($tipe_surat=='SM'){
//                $time = date('Y-m-d H:i:s');
                $datastat = array('stat'=>'15', 'end'=>$time);
                $where = 'id_suratmasuk='.$id_surat;
                $this->model->update('suratmasuk',$datastat,$where); //update status -> arsip
            }elseif($tipe_surat=='SK'){
//                $time = date('Y-m-d H:i:s');
                $datastat = array('status'=>'23', 'end'=>$time);
                $where = 'id_suratkeluar='.$id_surat;
                $this->model->update('suratkeluar',$datastat,$where); //update status -> arsip
            }
            
            echo "<div id=success>Rekam arsip berhasil</div>";
        }else{
            echo "<div id=error>Rekam arsip gagal!</div>";
        }
        
//        return true;
    }
    
    public function ubahArsip(){
        $id_arsip = $_POST['id_arsip'];
        $id_lokasi = $_POST['box'];
        $id_surat = $_POST['id'];
        $tipe_surat = $_POST['tipe'];
        $jenis = $_POST['jenis'];
        
        $data = array(
            'id_lokasi'=>$id_lokasi,
            'id_surat'=>$id_surat,
            'tipe_surat'=>$tipe_surat,
            'jenis'=>$jenis
        );
        
        $where = ' id_arsip='.$id_arsip;
        if($this->model->editArsip($data, $where)){
            $this->view->success = "Data arsip telah berhasil disimpan";
            
            echo "<div id=success>Ubah arsip berhasil</div>";
        }else{
            echo "<div id=error>Ubah arsip gagal!</div>";
        }
    }
    
    public function ikhtisar($key=null,$value=null) {
        $ikhtarsip = new IkhtisharArsip();
        if(!is_null($key)){
            $ikhtisar = $ikhtarsip->generateIkhtisharArsip($key, $value);
        }else{
            $ikhtisar = $ikhtarsip->generateIkhtisharArsip();
        }
        
        echo "<div id=table-wrapper><h2 align=center><font color=black>DAFTAR IKHTISAR DOKUMEN/ARSIP</font></h2>";
        echo "<h3 align=center>".Kantor::getNama()."</h3>";
        echo "</br><div id=chart-wrapper><table class=CSSTableGenerator>";
        echo "<tr><td><font color=black><b>No</b></font></td>
            <td><font color=black><b>Asal Arsip</b></font></td>
            <td><font color=black><b>Kurun Waktu</b></font></td>
            <td><font color=black><b>Jumlah</b></font></td>
            <td><font color=black><b>Format</b></font></td>
            <td><font color=black><b>Jalan Masuk</b></font></td>
            <td><font color=black><b>Penataan</b></font></td>
            <td><font color=black><b>Lokasi</b></font></td>
            <td><font color=black><b>Ket</b></font></td>
            </tr>";
        $no=1;
        foreach ($ikhtisar as $key => $value) {
            $lokasi = $value['lokasi'];
            for($i=0;$i<count($lokasi);$i++){
                $lokasi[$i] = "<a href=#><div onclick=getarsiplokasi('".$lokasi[$i]."');>$lokasi[$i]</div></a>";
            }
            $klas = $value['klas'];
            for($i=0;$i<count($klas);$i++){
                $klas[$i] = "<a href=#><div onclick=getarsipklas('".str_replace(" ", "-", $klas[$i])."');>$klas[$i]</div></a>";
            }
            echo "<tr><td ><font color=black><b>".$no."</b></font></td>
            <td ><font color=black><b>".$value['bagian']."</br></b></font></td>
            <td ><font color=black><b>".implode('</br>', $value['kurun'])."</br></b></font></td>
            <td ><font color=black><b>".$value['jumlah']." box</br></b></font></td>
            <td ><font color=black><b>kertas</br></b></font></td>
            <td ><font color=black><b>-</br></b></font></td>
            <td ><font color=black><b>-</br></b></font></td>
            <td ><font color=black><b>".implode(', ', $lokasi)."</br></b></font></td>
            <td ><font color=black><b>".implode(', ', $klas)."</br></b></font></td>
            </tr>";
            $no++;
        }
        echo "</table></div></div>";
        
    }
    
    public function ikhtisarLokasi(){
        $lokasi = $_POST['queryString'];
        $lokasi = explode("-", $lokasi);
        $ikhtisar = new IkhtisharArsip();
        $id = $ikhtisar->getArsipbyLokasi($lokasi);      
        
        echo "<div id=table-wrapper><h2 align=center><font color=black>DAFTAR IKHTISAR DOKUMEN/ARSIP</font></h2>";
        echo "<h3 align=center>LOKASI ARSIP : ".implode("->", $lokasi)."</h3>";
        echo "</br><div id=chart-wrapper><table class=CSSTableGenerator>";
        echo "<tr><td><font color=black><b>No</b></font></td>
            <td><font color=black><b>Uraian</b></font></td>
            <td><font color=black><b>Tipe Surat</b></font></td>
            <td><font color=black><b>Tipe Naskah</b></font></td>            
            </tr>";
        $no=1;
        
        foreach ($id as $val){
            $tipe = $val->tipe=='SM'?'Surat Masuk':'Surat Keluar';
            $lamp = new Lampiran_Model();
            $lampsurat = $lamp->getLampiranSurat($val->id_surat, $val->tipe);
            $lampiran = '';
            foreach ($lampsurat as $value){
                $tgl = is_null($value['tanggal'])?'':Tanggal::tgl_indo($value['tanggal']);
                $lampiran .= $value['nomor'].' : '. $tgl .'</br>'.$value['hal'].'<hr>';
            }
            $tgl_surat = is_null($val->tgl_surat)?'':Tanggal::tgl_indo($val->tgl_surat);
            echo "<tr><td><font color=black><b>$no</b></font></td>
            <td><font color=black><b>$val->no_surat : ".  $tgl_surat."</br>$val->alamat</b></font>";
            if($lampiran!=''){
                echo '<hr><b>LAMPIRAN :</b></br>'.$lampiran;
            }
            echo "</td>
            <td><font color=black><b>$tipe</b></font></td>
            <td><font color=black><b>$val->klas</b></font></td>            
            </tr>";
            $no++;
        }
    }
    
    public function ikhtisarKlas(){
        $klas = $_POST['queryString'];
        $klas = str_replace("-", " ", $klas);
        $ikhtisar = new IkhtisharArsip();
        $id = $ikhtisar->getArsipByKlasifikasi($klas);    
        
        echo "<div id=table-wrapper><h2 align=center><font color=black>DAFTAR IKHTISAR DOKUMEN/ARSIP</font></h2>";
        echo "<h3 align=center>KLASIFIKASI ARSIP : ".$klas."</h3>";
        echo "</br><div id=chart-wrapper><table class=CSSTableGenerator>";
        echo "<tr><td><font color=black><b>No</b></font></td>
            <td><font color=black><b>Uraian</b></font></td>
            <td><font color=black><b>Tipe Surat</b></font></td>
            <td><font color=black><b>Tipe Naskah</b></font></td>            
            </tr>";
        $no=1;
        
        foreach ($id as $val){
            $tipe = $val->tipe=='SM'?'Surat Masuk':'Surat Keluar';
            $lamp = new Lampiran_Model();
            $lampsurat = $lamp->getLampiranSurat($val->id_surat, $val->tipe);
            $lampiran = '';
            foreach ($lampsurat as $value){
                $tgl = is_null($value['tanggal'])?'':Tanggal::tgl_indo($value['tanggal']);
                $lampiran .= $value['nomor'].' : '. $tgl .'</br>'.$value['hal'].'<hr>';
            }
            $tgl_surat = is_null($val->tgl_surat)?'':Tanggal::tgl_indo($val->tgl_surat);
            echo "<tr><td><font color=black><b>$no</b></font></td>
            <td><font color=black><b>$val->no_surat : ".  $tgl_surat."</br>$val->alamat</b></font>";
            if($lampiran!=''){
                echo '<hr><b>LAMPIRAN :</b></br>'.$lampiran;
            }
            echo "</td>
            <td><font color=black><b>$tipe</b></font></td>
            <td><font color=black><b>$val->klas</b></font></td>            
            </tr>";
            $no++;
        }
    }
    
    function __destruct() {
        ;
    }

}
?>
