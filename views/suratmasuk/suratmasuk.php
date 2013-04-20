<h2>Daftar Surat Masuk</h2>

        <hr>
        </br>
        <?php if(Auth::isRole($role, 5)) {?><a href="<?php echo URL;?>suratmasuk/rekam"><input class="btn" type="button" value="R E K A M"></a>
        <a ><input class="btn" id="x" type="button" value="CETAK DISPOSISI" onclick="cetakdisp();"></a>
            <?php } ?>
        <?php if(Auth::isRole($role, 5) OR Auth::isRole($role, 4)) {?><a href="<?php echo URL;?>suratmasuk/ctkEkspedisi"><input class="btn" type="button" value="CETAK EKSPEDISI"></a><?php } ?>
        <div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><td >AGENDA</td><td >INFORMASI SURAT</td><td >AKSI</td></tr>
    <form name="sm" >
<?php
    foreach($this->listSurat as $key => $value) {
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        //var_dump($this->notif->isRead($value['id_suratmasuk'],$user,'SM'));
        if($this->notif->isRead($value['id_suratmasuk'],$user,'SM')){
            echo '<td><input type=checkbox id=cek name=cek[] value=' . $value['id_suratmasuk'] . '> <font color=blue><strong>' . Tanggal::tgl_indo($value['tgl_terima']) . '</br>'.$value['no_agenda']. '</strong></font></td>';
            echo '<td><b><font color=blue><a href="'.URL.'suratmasuk/detil/'.$value['id_suratmasuk'].'">' . $value['no_surat'] . '</a> || '
            . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'. $value['asal_surat'] . '</br>'. $value['perihal'] .
             '</font></b></td>';
        }else{
            echo '<td><input type=checkbox id=cek name=cek[] value=' . $value['id_suratmasuk'] . '> ' . Tanggal::tgl_indo($value['tgl_terima']) . '</br>'.$value['no_agenda']. '</td>';
            echo '<td><a href="'.URL.'suratmasuk/detil/'.$value['id_suratmasuk'].'">' . $value['no_surat'] . '</a> || '
            . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'. $value['asal_surat'] . '</br>'. $value['perihal'] .
             '</td>';
        }
        
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td>';
                if(Auth::isRole($role, 2) AND Auth::isBagian($bagian, 1))echo '<a href="'.URL.'suratmasuk/edit/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Ubah></a> 
                <a href="'.URL.'suratmasuk/remove/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Hapus onclick="return selesai()"></a>';
                if(Auth::isRole($role, 1) OR Auth::isRole($role, 4)) echo '<a href="'.URL.'suratmasuk/disposisi/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Disposisi></a>';
                if(Auth::isRole($role, 5)) echo '<a><input class=btn type=button value="Cetak Disposisi" onclick=cetakdisposisi('.$value['id_suratmasuk'].');></a> ';
                if(Auth::isRole($role, 5) OR Auth::isRole($role, 3)) echo '<a href="'.URL.'suratmasuk/upload/'.$value['id_suratmasuk'].'"><input class=btn type=button value="Upload File"></a>
                <!--<a href="'.URL.'suratmasuk/updatestatus/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Status></a>
                    <a href="'.URL.'suratmasuk/distribusi/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Distribusi></a>--></td>';
        echo '</tr>';
    }
?>
    </form>
</table></div>
        <div id="result"></div>
        
<script type="text/javascript">

function selesai(){
    var answer = 'anda yakin menghapus data surat?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
    
}

function cetakdisp(){ 
    
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
        url = url.substr(1);        
//        alert(url);
        var w = window.open("<?php echo URL; ?>suratmasuk/disposisix/"+url, "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=600,height=500");        
        
    }
    else {
        alert('Surat belum dipilih!');
    }    
   
    
}

function cetakdisposisi(id){
    w = window.open("<?php echo URL; ?>suratmasuk/ctkDisposisi/"+id, "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=600,height=500");        
}


</script>