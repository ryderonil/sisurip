<h2>Daftar Surat Keluar</h2>

        <hr>
        </br>
        <a href="<?php echo URL;?>suratkeluar/rekam"><input class="btn" type="button" value="R E K A M"></a>
        <div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><td >NOMOR</td><td >INFORMASI SURAT</td><td >AKSI</td></tr>
<?php
    foreach($this->data as $key => $value) {
        if($value['no_surat']==''){
            $no_surat = ucfirst($value['status']);
        }else{
            $no_surat = $value['no_surat'];
        }
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        echo '<td>' . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'.$no_surat. '</td>';
        echo '<td>' . $value['tipe'] . ' 
            </br><a href="'.URL.'suratkeluar/detil/'.$value['id_suratkeluar'].'">'. $value['tujuan'] . '</br>'. $value['perihal'] .
             '</a></td>';
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td>
                <a href="'.URL.'suratkeluar/edit/'.$value['id_suratkeluar'].'"><input class=btn type=button value=Ubah></a> 
                <a href="'.URL.'suratkeluar/remove/'.$value['id_suratkeluar'].'"><input class=btn type=button value=Hapus onclick="return selesai()"></a>
                    <a href="'.URL.'suratkeluar/upload/'.$value['id_suratkeluar'].'"><input class=btn type=button value="Upload File"></a></td>';
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