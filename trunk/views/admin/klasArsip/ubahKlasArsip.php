<h2>Ubah Klasifikasi Arsip</h2>
<hr>
<div id="form-wrapper">
<form id="form-rekam" method="POST" action="#">
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamKlasArsip">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>KODE KLASIFIKASI</label><input class="required" type="text" name="kode" value="<?php echo $this->data[1];?>"></br>
    <label>KLASIFIKASI</label><input class="required" type="text" name="klasifikasi" value="<?php echo $this->data[2];?>"></br>
    <label></label><input type="button" onclick="location.href='<?php echo URL;?>admin/rekamKlasifikasiArsip'" value="BATAL"><input type="submit" name="submit" value="SIMPAN" onclick="return selesai();">
</form></div>

</br>
<hr>
</br>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>KODE</th><th>KLASIFIKASI</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->klasArsip as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['kode']; ?></td>
        <td><?php echo $value['klasifikasi']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai();"></a></td></tr>
    <?php $no++; }?>
</table></div>

<script type="text/javascript">
    
    function selesai()
{
    
  var answer = confirm ("Anda yakin menyimpan perubahan?")
    if (answer)
        return true;
    else
        //window.location='<?php echo URL;?>admin/ubahLokasi/<?php echo $this->data[0];?>';
        return false;
    }
    

</script>
