<h1>Ubah Klasifikasi Arsip</h1>
<form method="POST" action="<?php echo URL; ?>admin/updateRekamKlasArsip">
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>KODE KLASIFIKASI</label><input type="text" name="kode" value="<?php echo $this->data[1];?>"></br>
    <label>KLASIFIKASI</label><input type="text" name="klasifikasi" value="<?php echo $this->data[2];?>"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>


<div class="CSSTableGenerator"><table border="1">
    <tr><th>NO</th><th>KODE</th><th>KLASIFIKASI</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->klasArsip as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['kode']; ?></td>
        <td><?php echo $value['klasifikasi']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>">UBAH</a> | 
            <a href="<?php echo URL;?>admin/hapusKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>">HAPUS</a></td></tr>
    <?php $no++; }?>
</table></div>
