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
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    
    public function rekam($id,$tipesurat=null){
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
//                $data = $this->model->select('SELECT id_suratmasuk, no_surat, asal_surat, perihal
//                    FROM suratmasuk WHERE id_suratmasuk='.$id);
//                foreach ($data as $value){
                    $this->view->data[0] = $data->getId();
                    $this->view->data[1] = $data->getNomor();
                    $this->view->data[2] = $data->getAlamat();
                    $this->view->data[3] = $data->getPerihal();
//                }
            }elseif (($tipesurat=='SK')) {
                $data = $this->model->getSurat($id,'SK');
//                $data=$this->model->select('SELECT id_suratkeluar,no_surat,tujuan, perihal
//                    FROM suratkeluar WHERE id_suratkeluar='.$id);
//                foreach ($data as $value){
                    $this->view->data[0] = $data->getId();
                    $this->view->data[1] = $data->getNomor();
                    $this->view->data[2] = $data->getAlamat();
                    $this->view->data[3] = $data->getPerihal();
//                }
            }
        }
        
        $dataa = $this->model->getArsip($id, $tipesurat);
//        var_dump($dataa);
        $this->view->cek = count($dataa);
        if($this->view->cek>0){
//            ini yang susah ternyata
//            foreach ($dataa  as $val){                
                $this->view->ar['rak'] = $dataa->lokasi[1];
                $this->view->ar['baris'] = $dataa->lokasi[2];
                $this->view->ar['box'] = $dataa->lokasi[3];
                $this->view->ar['klas'] = $dataa->klas;
//            }
            
            $this->view->rak = $this->model->getRak();
            $this->view->baris = $this->model->getBaris($this->view->ar['rak']);
            $this->view->box = $this->model->getBox($this->view->ar['baris']);
            $this->view->klas = $this->model->getKlas();
            
        }else{
//            if($this->view->data[1]==''){
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
        $jenis = $_POST['klas'];
        
        $data = array(
            'id_lokasi'=>$id_lokasi,
            'id_surat'=>$id_surat,
            'tipe_surat'=>$tipe_surat,
            'jenis'=>$jenis
        );
        
        if($this->model->rekamArsip($data)){
            $this->view->success = "Data arsip telah berhasil disimpan";
        
            if($tipe_surat=='SM'){
                $time = date('Y-m-d H:i:s');
                $datastat = array('stat'=>'15', 'end'=>$time);
                $where = 'id_suratmasuk='.$id_surat;
                $this->model->update('suratmasuk',$datastat,$where); //update status -> arsip
//                header('location:'.URL.'suratmasuk/detil/'.$id_surat);
            }elseif($tipe_surat=='SK'){
                $time = date('Y-m-d H:i:s');
                $datastat = array('status'=>'23', 'end'=>$time);
                $where = 'id_suratkeluar='.$id_surat;
                $this->model->update('suratkeluar',$datastat,$where); //update status -> arsip
//                header('location:'.URL.'suratkeluar/detil/'.$id_surat);
            }
        }
        
        return true;
        
//        pesan berhasilnya mana
//        $this->view->rak = $this->model->getRak();
//        $this->view->baris = $this->model->getBaris();
//        $this->view->box = $this->model->getBox();
//        $this->view->render('arsip/rekam');
        
        
    }
    
    public function ikhtisar($key=null,$value=null) {
        $ikhtarsip = new IkhtisharArsip();
        if(!is_null($key)){
            $ikhtisar = $ikhtarsip->generateIkhtisharArsip($key, $value);
        }else{
            $ikhtisar = $ikhtarsip->generateIkhtisharArsip();
        }
        
//        var_dump($ikhtisar);
        
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
//        var_dump($ikhtisar);
        foreach ($ikhtisar as $key => $value) {
            $lokasi = $value['lokasi'];
            for($i=0;$i<count($lokasi);$i++){
//                $lok = str_replace("-", ",", $lokasi[$i]);
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
        $id = $this->model->getArsipByLokasi($lokasi);        
        
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
        $id = $this->model->getArsipByKlas($klas);        
        
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

}
?>
