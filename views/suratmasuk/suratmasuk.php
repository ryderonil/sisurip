<div class="divleft"><h2>Daftar Surat Masuk</h2></div>
<!--<select id="pull-right">-->
<!--    <option>pilih semua</option>-->
<!--</select></div>-->

        <hr>        <!--
        <?php if(Auth::isRole($role, 5)) {?><a href="<?php echo URL;?>suratmasuk/rekam" title="rekam surat masuk" class="tip"><input class="btn" type="button" value="R E K A M"></a>
        <a title="cetak disposisi lebih dari satu surat, pilih surat yang akan dicetak!" class="tip"><input class="btn" id="x" type="button" value="CETAK DISPOSISI" onclick="cetakdisp();"></a>
            <?php } ?>
        <?php if(Auth::isRole($role, 5) OR Auth::isRole($role, 4)) {?><a href="<?php echo URL;?>suratmasuk/ctkEkspedisi" title="cetak ekspedisi surat" class="tip"><input class="btn" type="button" value="CETAK EKSPEDISI"></a><?php } ?>-->
        <div class="nav-paging"><div class="limit">
                <?php if(Auth::isRole($role, 5)) {?><a href="<?php echo URL;?>suratmasuk/rekam" title="rekam surat masuk" class="tip"><input class="btn write" type="button" value="R E K A M"></a>
        <a title="cetak disposisi lebih dari satu surat, pilih surat yang akan dicetak!" class="tip"><input class="btn print" id="x" type="button" value="DISPOSISI" onclick="cetakdisp(1);"></a>
            <?php } ?>
        <?php if(Auth::isRole($role, 5) OR Auth::isRole($role, 4)) {?><a  title="cetak ekspedisi surat" class="tip"><input class="btn print" id="exp" type="button" value="EKSPEDISI" onclick="cetakdisp(2);;"></a><?php } ?>
            </div>            
        <?php
        if($this->jmlData>0){
            $jmlhal = $this->paging->jml_halaman($this->jmlData);
            $paging = $this->paging->navHalaman($jmlhal);
            echo $paging;
        ?>
        </div>
        </br>
        <div id="table-wrapper" style="max-height:400px;"><table class="CSSTableGenerator">
    <tr><td >AGENDA</td><td >INFORMASI SURAT</td><td >AKSI</td></tr>
    <form name="sm" >
<?php
    $no=1;
    $arsip = new Arsip_Model();
    foreach($this->listSurat as $value) {
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        //var_dump($this->notif->isRead($value['id_suratmasuk'],$user,'SM'));
        if($this->notif->isRead($value->getId(),$user,'SM')){
            echo '<td width=20%><input type=checkbox id=cek'.$no.' name=cek[] value=' . $value->getId() . ' onchange=cek();> <font color=blue><strong>' . Tanggal::tgl_indo($value->getTglTerima()) . '</br>'.$value->getAgenda(). '</strong></font></br>';
            if(!$arsip->isHasBeenArchived($value->getId(),'SM')){
                $mon = new Monitoring_Model();
                $add = (int) $mon->getDueDate('SM');
                $due_date = $mon->findNextHour($value->getStart(),$add);
                $tgl = explode(' ', $due_date);
                echo '<font color=red>batas waktu : '.Tanggal::tgl_indo($tgl[0]).' '.$tgl[1].'</font>';
            }
            echo '</td>';
            echo '<td width=50%><b><font color=blue><a href="'.URL.'suratmasuk/detil/'.$value->getId().'" title="klik disini untuk melihat detil surat" class=tip>' . $value->getNomor() . '</a> || '
            . Tanggal::tgl_indo($value->getTglSurat()) . '</br>'. $value->getAlamat(). '</br><i>'. $value->getPerihal() .
             '</i></font></b></td>';
        }else{
            echo '<td width=20%><input type=checkbox id=cek name=cek[] value=' . $value->getId() . ' onchange=cek();> ' . Tanggal::tgl_indo($value->getTglTerima()) . '</br>'.$value->getAgenda(). '</br>';
            if(!$arsip->isHasBeenArchived($value->getId(),'SM')){
                $mon = new Monitoring_Model();
                $add = (int) $mon->getDueDate('SM');
                $due_date = $mon->findNextHour($value->getStart(),$add);
                $tgl = explode(' ', $due_date);
                echo '<font color=red>batas waktu : '.Tanggal::tgl_indo($tgl[0]).' '.$tgl[1].'</font>';
            }
            echo '</td>';
            echo '<td width=50%><a href="'.URL.'suratmasuk/detil/'.$value->getId().'" title="klik disini untuk melihat detil surat" class=tip>' . $value->getNomor() . '</a> || '
            . Tanggal::tgl_indo($value->getTglSurat()) . '</br>'. $value->getAlamat() . '</br><font color=grey><i>'. $value->getPerihal() .
             '</i></font></td>';
        }
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td halign=center width=30%>';
                if(Auth::isRole($role, 2) AND Auth::isBagian($bagian, 1))echo '<a href="'.URL.'suratmasuk/edit/'.$value->getId().'" title="ubah data surat" class=tip><input class="btn btn-green" type=button value=ubah></a> 
                <a href="'.URL.'suratmasuk/hapus/'.$value->getId().'" title="hapus data surat" class=tip><input class="btn btn-danger" type=button value="hapus" onclick="return selesai(\'' . $value->getAgenda() . '\');"></a>';
                if(Auth::isRole($role, 1) OR Auth::isRole($role, 4)) echo '<a href="'.URL.'suratmasuk/disposisi/'.$value->getId().'" title="rekam disposisi" class=tip><input class="btn write" type=button value=disposisi></a>';
                if(Auth::isRole($role, 5)) echo '<a title="cetak disposisi" class=tip><input class="btn print" type=button value="disposisi" onclick="cetakdisposisi('.$value->getId().');"></a> ';
                if(Auth::isRole($role, 5) OR Auth::isRole($role, 3)) echo '<a href="'.URL.'suratmasuk/upload/'.$value->getId().'" title="upload file surat" class=tip><input class="btn upload" type=button value="upload"></a>
                <!--<a href="'.URL.'suratmasuk/updatestatus/'.$value->getId().'"><input class=btn type=button value=Status></a>
                    <a href="'.URL.'suratmasuk/distribusi/'.$value->getId().'"><input class=btn type=button value=Distribusi></a>--></td>';
        echo '</tr>';        
        $no++;
    }
    
        
     
?>
    </form>
</table></div>
        <?php }else{ ?>
        </div>
            <br><br><br><br><br><br><br><br>
            <h1 align="center">Data tidak ditemukan</h1>
        <?php } ?>
        
        <div id="result"></div>
        
<script type="text/javascript">
    
    $(document).ready(function(){
//        $('#x').fadeOut(0);
//        $('#exp').fadeOut(0);
    });
    
function selesai(agenda){
    var answer = 'anda yakin menghapus data surat dengan nomor agenda : '+agenda+'?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
    
}

function cetakdisp(num){ 
    
    var counter = 0,       
        url = '', 
        input_obj = document.getElementsByTagName('input');    
    for (i = 0; i < input_obj.length; i++) {        
        if (input_obj[i].type === 'checkbox' && input_obj[i].checked === true) {            
            counter++;
            url = url + ',' + input_obj[i].value;
        }
    }
    
    if (counter > 0) {
//          alert(counter+',');
        url = url.substr(1);        
//        alert(url);
        if(num==1){
            var w = window.open("<?php echo URL; ?>suratmasuk/disposisix/"+url, "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=800,height=500");        
        }else if(num==2){
            w = window.open("<?php echo URL; ?>suratmasuk/ctkEkspedisi/"+url, "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=800,height=500");
        }
        
        
    }
    else {
        if(num==2){
            cetakekspedisi();
        }else{
            alert('Surat belum dipilih!'); 
        }
        
    }    
   
    
}

function cetakdisposisi(id){
    w = window.open("<?php echo URL; ?>suratmasuk/ctkDisposisi/"+id, "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=800,height=500");        
}

function cetakekspedisi(){
    w = window.open("<?php echo URL; ?>suratmasuk/ctkEkspedisi", "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=800,height=500");        
}

$(function(){
    $(".tip").tipTip({maxWidth: "auto", edgeOffset: 10});
});


</script>