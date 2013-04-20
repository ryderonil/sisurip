<h2>Tambah Jenis Lampiran</h2><hr>
<div id="form-wrapper">
<form id="form-rekam" method="POST" action="#">    
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamLampiran">    -->
     <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>           
        
    <label>TIPE NASKAH DINAS</label><input class="required" type="text" name="tipe_naskah"></br>
    <label>KODE SURAT</label><input class="required" type="text" name="kode_naskah"></br>
    <label></label><input type="reset" name="submit" value="RESET"><input type="submit" name="submit" value="SIMPAN">
</form></div>
</br>
<hr>
</br>
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>TIPE NASKAH</th><th>AKSI</th></tr>
    <?php foreach($this->lampiran as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>        
        <td><?php echo $value['tipe_naskah']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahLampiran/<?php echo $value['id_tipe'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusLampiran/<?php echo $value['id_tipe'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai();"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>

<script type="text/javascript">

function selesai(){
    
    var answer = 'anda yakin menghapus data ini?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
}


</script>