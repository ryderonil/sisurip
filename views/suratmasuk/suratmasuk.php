<h2>Daftar Surat Masuk</h2>

        <hr>
        </br>
        <a href="<?php echo URL;?>suratmasuk/rekam"><input class="btn" type="button" value="R E K A M"></a>
        <a href="<?php echo URL;?>suratmasuk/ctkEkspedisi"><input class="btn" type="button" value="CETAK EKSPEDISI"></a>
        <div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><td >AGENDA</td><td >INFORMASI SURAT</td><td >AKSI</td></tr>
<?php
    foreach($this->listSurat as $key => $value) {
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        echo '<td>' . Tanggal::tgl_indo($value['tgl_terima']) . '</br>'.$value['no_agenda']. '</td>';
        echo '<td><a href="'.URL.'suratmasuk/detil/'.$value['id_suratmasuk'].'">' . $value['no_surat'] . '</a> || '
            . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'. $value['asal_surat'] . '</br>'. $value['perihal'] .
             '</td>';
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td>
                <a href="'.URL.'suratmasuk/edit/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Ubah></a> 
                <a href="'.URL.'suratmasuk/remove/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Hapus onclick="return selesai()"></a>
                <a href="'.URL.'suratmasuk/disposisi/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Disposisi></a>
                <a href="'.URL.'suratmasuk/ctkdisposisi/'.$value['id_suratmasuk'].'"><input class=btn type=button value="Cetak Disposisi"></a>
                    <a href="'.URL.'suratmasuk/upload/'.$value['id_suratmasuk'].'"><input class=btn type=button value="Upload File"></a>
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