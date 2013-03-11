<h1>Tambah Klasifikasi Arsip</h1>
<form method="POST" action="<?php echo URL; ?>admin/inputRekamKlasArsip">
                
        <hr>
    <label>KODE KLASIFIKASI</label><input type="text" name="kode"></br>
    <label>KLASIFIKASI</label><input type="text" name="klasifikasi"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>

<?php if($this->count>0) { $no=1;?>
<div class="CSSTableGenerator"><table border="1">
    <tr><th>NO</th><th>KODE</th><th>KLASIFIKASI</th><th>AKSI</th></tr>
    <?php foreach($this->klasArsip as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['kode']; ?></td>
        <td><?php echo $value['klasifikasi']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>">UBAH</a> | 
            <a href="<?php echo URL;?>admin/hapusKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>">HAPUS</a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>