<h1>Tambah Format Nomor Surat</h1>
<form method="POST" action="<?php echo URL; ?>admin/inputRekamNomor">              
        <hr>
    <label>FORMAT NOMOR</label><input type="text" name="nomor"></br>
    <label>BAGIAN</label><select name="bagian">
        <option name="" selected>--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value) { ?>
        <option value="<?php echo $value['kd_bagian'];?>"> <?php echo strtoupper($value['bagian']);?></option>
        <?php } ?>
    </select></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>

<?php if($this->count>0) { $no=1;?>
<table border="1">
    <tr><th>NO</th><th>BAGIAN</th><th>KODE NOMOR</th><th>AKSI</th></tr>
    <?php foreach($this->nomor as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['bagian']; ?></td>
        <td><?php echo $value['kd_nomor']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahNomor/<?php echo $value['id_nomor'];?>">UBAH</a> | 
            <a href="<?php echo URL;?>admin/hapusNomor/<?php echo $value['id_nomor'];?>">HAPUS</a></td></tr>
    <?php $no++; }?>
</table>
<?php } ?>