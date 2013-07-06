<div class="divleft"><h2>Daftar Surat Keluar</h2></div>
<!--<select id="pull-right">-->
<!--    <option>pilih semua</option>-->
<!--</select></div>-->

        <hr>
        <div class="nav-paging"><div class="limit">
        <?php if(Auth::isRole($role, 3)) {?><a href="<?php echo URL;?>suratkeluar/rekam" title="rekam data surat keluar" class="tip"><input class="btn write" type="button" value="R E K A M"></a><?php } ?>
            </div>
            <?php
            if($this->jmlData>0){
                $jmlhal = $this->paging->jml_halaman($this->jmlData);
                $paging = $this->paging->navHalaman($jmlhal);
                echo $paging;
            ?>
            <!--<div class="paging">                
                <input type="button" class="btn" value="<">
                <input type="button" class="btn" value=">">
                <select id="limit" class="limit-select">
                    <option value=10>   10</option>  
                    <option value=20>   20</option>
                    <option value=30>   30</option>
                </select>
            </div>--></div></br>
        <div id="table-wrapper" style="max-height:400px;"><table class="CSSTableGenerator">
    <tr><td >NOMOR</td><td >INFORMASI SURAT</td><td >AKSI</td></tr>
<?php
    $arsip = new Arsip_Model();
    $mon = new Monitoring_Model();
    foreach($this->data as $value) {
        if($value->getNomor()==''){
            $no_surat = ucfirst($value->getStatus());
        }else{
            $no_surat = $value->getNomor();
        }
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        
        if($this->notif->isRead($value->getId(),$user,'SK')){
//            <input type=checkbox name=cek[] value=' . $value->getId() . ' >
            echo '<td width=20%> <font color=blue><b>' . Tanggal::tgl_indo($value->getTglSurat()) . '</br>'.$no_surat. '</br>';
            if(!$arsip->isHasBeenArchived($value->getId(),'SK')){
                $mon = new Monitoring_Model();
                $add = (int) $mon->getDueDate('SK',$value->getId());
                $due_date = $mon->cekNextDay($value->getStart(),false,($add/24));
                $tgl = explode(' ', $due_date);
                echo '<font color=red>batas waktu : '.Tanggal::tgl_indo($tgl[0]).' '.$tgl[1].'</font>';
            }
            echo '</td>';
            echo '<td width=50%' . $value->getTipeSurat() . ' <font color=green>[' .$value->getUserCreate(). ']</font> 
            </br><a href="'.URL.'suratkeluar/detil/'.$value->getId().'" title="klik disini untuk melihat detil surat!" class=tip>'. $value->getAlamat() . '</br><i>'. $value->getPerihal() .
             '</i></a></b></font></td>';
        }else{
            echo '<td width=20%> ' . Tanggal::tgl_indo($value->getTglSurat()) . '</br>'.$no_surat. '</br>';
            if(!$arsip->isHasBeenArchived($value->getId(),'SK')){
                $mon = new Monitoring_Model();
                $add = (int) $mon->getDueDate('SK',$value->getId());
                $due_date = $mon->cekNextDay($value->getStart(),false,($add/24));
                $tgl = explode(' ', $due_date);
                echo '<font color=red>batas waktu : '.Tanggal::tgl_indo($tgl[0]).' '.$tgl[1].'</font>';
            }
            echo '</td>';
            echo '<td width=50%>' . $value->getTipeSurat() . ' <font color=green><i>[' .$value->getUserCreate(). ']</i></font> 
            </br><a href="'.URL.'suratkeluar/detil/'.$value->getId().'" title="klik disini untuk melihat detil surat!" class=tip>'. $value->getAlamat() . '</br><i>'. $value->getPerihal() .
             '</i></a></td>';
        }
        
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td width=30%>';
                if(Auth::isRole($role, 2)) echo '<a href="'.URL.'suratkeluar/edit/'.$value->getId().'" title="ubah data surat" class=tip><input class="btn btn-green" type=button value=Ubah></a> 
                <a href="'.URL.'suratkeluar/remove/'.$value->getId().'" title="hapus data surat" class=tip><input class="btn btn-danger" type=button value=Hapus onclick="return selesai()"></a> ';
                if(!Auth::isRole($role, 5) AND !Auth::isRole($role, 4)) echo '<a href="'.URL.'suratkeluar/rekamrev/'.$value->getId().'" title="rekam revisi surat" class=tip><input class="btn write" type=button value="Revisi"></a> ';
                echo '<a href="'.URL.'suratkeluar/download/'.$value->getId().'" title="download file surat" class=tip><input class="btn download" type=button value="Download"></a></td>';
        echo '</tr>';
    }
?>
</table></div>
            <?php }else{ ?>
        </div>
            <br><br><br><br><br><br><br><br>
            <h1 align="center">Data tidak ditemukan</h1>
        <?php } ?>
        
<script type="text/javascript">

function selesai(){
    var answer = 'anda yakin menghapus data surat?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
}

</script>