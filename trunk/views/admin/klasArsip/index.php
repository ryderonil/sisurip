<h2>Tambah Klasifikasi Arsip</h2>
 <hr>
<div id="form-wrapper">
<form id="form-rekam" method="POST" action="#">
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamKlasArsip">-->
    <?php 
            if (isset($this->error)) {
        echo "<div id=error>$this->error<?div>";
    } elseif (isset($this->success)) {
        echo "<div id=success>$this->success</div>";
    }
    ?>
       
    <label>KODE KLASIFIKASI</label><input class="required" type="text" name="kode"></br>
    <label>KLASIFIKASI</label><input class="required" type="text" name="klasifikasi"></br>
    <label></label><input type="reset" value="RESET"><input type="submit" name="submit" value="SIMPAN">
</form></div>
</br>
<hr>
</br>
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>KODE</th><th>KLASIFIKASI</th><th>AKSI</th></tr>
    <?php foreach($this->klasArsip as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['kode']; ?></td>
        <td><?php echo $value['klasifikasi']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai('<?php echo $value['klasifikasi'];?>');"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>

<script type="text/javascript">
    
    function selesai(klas)
{
   
        var answer = confirm ("Klasifikasi arsip : "+klas+" akan dihapus?");
   
  
    if (answer){
        return true;
    }else{
        
        return false;
    }
    
    }
    
    
    

</script>