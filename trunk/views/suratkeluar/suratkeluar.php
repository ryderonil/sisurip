<h2>Daftar Surat Keluar</h2>
<!--<select id="pull-right">-->
<!--    <option>pilih semua</option>-->
<!--</select></div>-->

        <hr>
        <div class="nav-paging"><div class="limit">
        <?php if(Auth::isRole($role, 3)) {?><a href="<?php echo URL;?>suratkeluar/rekam" title="rekam data surat keluar" class="tip"><input class="btn" type="button" value="R E K A M"></a><?php } ?>
            </div><div class="paging">                
                <input type="button" class="btn" value="<">
                <input type="button" class="btn" value=">">
                <select id="limit" class="limit-select">
                    <option value=10>   10</option>  
                    <option value=20>   20</option>
                    <option value=30>   30</option>
                </select>
            </div></div></br>
        <div id="table-wrapper" style="overflow:scroll; height:400px;"><table class="CSSTableGenerator">
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
        
        if($this->notif->isRead($value['id_suratkeluar'],$user,'SK')){
            echo '<td><input type=checkbox name=cek[] value=' . $value['id_suratkeluar'] . ' > <font color=blue><b>' . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'.$no_surat. '</td>';
            echo '<td>' . $value['tipe'] . ' 
            </br><a href="'.URL.'suratkeluar/detil/'.$value['id_suratkeluar'].'" title="klik disini untuk melihat detil surat!" class=tip>'. $value['tujuan'] . '</br>'. $value['perihal'] .
             '</a></b></font></td>';
        }else{
            echo '<td><input type=checkbox name=cek[] value=' . $value['id_suratkeluar'] . ' > ' . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'.$no_surat. '</td>';
            echo '<td>' . $value['tipe'] . ' 
            </br><a href="'.URL.'suratkeluar/detil/'.$value['id_suratkeluar'].'" title="klik disini untuk melihat detil surat!" class=tip>'. $value['tujuan'] . '</br>'. $value['perihal'] .
             '</a></td>';
        }
        
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td>';
                if(Auth::isRole($role, 2)) echo '<a href="'.URL.'suratkeluar/edit/'.$value['id_suratkeluar'].'" title="ubah data surat" class=tip><input class=btn type=button value=Ubah></a> 
                <a href="'.URL.'suratkeluar/remove/'.$value['id_suratkeluar'].'" title="hapus data surat" class=tip><input class=btn type=button value=Hapus onclick="return selesai()"></a> ';
                if(!Auth::isRole($role, 5) AND !Auth::isRole($role, 4))echo '<a href="'.URL.'suratkeluar/rekamrev/'.$value['id_suratkeluar'].'" title="rekam revisi surat" class=tip><input class=btn type=button value="Rekam Revisi"></a> ';
                echo '<a href="'.URL.'suratkeluar/download/'.$value['id_suratkeluar'].'" title="download file surat" class=tip><input class=btn type=button value="Download"></a></td>';
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