<h2>Tambah Format Nomor Surat</h2>
<hr>
<div id="form-wrapper">
<form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamNomor">              
       
    <label>FORMAT NOMOR</label><input class="required" type="text" name="nomor"></br>
    <label>BAGIAN</label><select class="required" name="bagian">
        <option name="" selected>--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value) { ?>
        <option value="<?php echo $value['kd_bagian'];?>"> <?php echo strtoupper($value['bagian']);?></option>
        <?php } ?>
    </select></br>
    <label></label><input type="reset" value="RESET"><input type="submit" name="submit" value="SIMPAN">
</form></div>
</br>
<hr>
</br>
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>BAGIAN</th><th>KODE NOMOR</th><th>AKSI</th></tr>
    <?php foreach($this->nomor as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['bagian']; ?></td>
        <td><?php echo $value['kd_nomor']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahNomor/<?php echo $value['id_nomor'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusNomor/<?php echo $value['id_nomor'];?>"><input class="btn" type="button" value="HAPUS"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>
