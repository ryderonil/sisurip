<h2>Daftar Surat Masuk</h2>

        <hr>
        </br>
        <?php if(Auth::isRole($role, 5)) {?><a href="<?php echo URL;?>suratmasuk/rekam"><input class="btn" type="button" value="R E K A M"></a><?php } ?>
        <?php if(Auth::isRole($role, 5) OR Auth::isRole($role, 4)) {?><a href="<?php echo URL;?>suratmasuk/ctkEkspedisi"><input class="btn" type="button" value="CETAK EKSPEDISI"></a><?php } ?>
        <div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><td >AGENDA</td><td >INFORMASI SURAT</td><td >AKSI</td></tr>
<?php
    foreach($this->listSurat as $key => $value) {
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        //var_dump($this->notif->isRead($value['id_suratmasuk'],$user,'SM'));
        if($this->notif->isRead($value['id_suratmasuk'],$user,'SM')){
            echo '<td><font color=blue><strong>' . Tanggal::tgl_indo($value['tgl_terima']) . '</br>'.$value['no_agenda']. '</strong></font></td>';
            echo '<td><b><font color=blue><a href="'.URL.'suratmasuk/detil/'.$value['id_suratmasuk'].'">' . $value['no_surat'] . '</a> || '
            . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'. $value['asal_surat'] . '</br>'. $value['perihal'] .
             '</font></b></td>';
        }else{
            echo '<td>' . Tanggal::tgl_indo($value['tgl_terima']) . '</br>'.$value['no_agenda']. '</td>';
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
                if(Auth::isRole($role, 5)) echo '<a href="'.URL.'suratmasuk/ctkdisposisi/'.$value['id_suratmasuk'].'"><input class=btn type=button value="Cetak Disposisi"></a> ';
                if(Auth::isRole($role, 5) OR Auth::isRole($role, 3)) echo '<a href="'.URL.'suratmasuk/upload/'.$value['id_suratmasuk'].'"><input class=btn type=button value="Upload File"></a>
                <!--<a href="'.URL.'suratmasuk/updatestatus/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Status></a>
                    <a href="'.URL.'suratmasuk/distribusi/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Distribusi></a>--></td>';
        echo '</tr>';
    }
?>
</table></div>
        
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