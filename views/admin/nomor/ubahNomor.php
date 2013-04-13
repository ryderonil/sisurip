<h2>Ubah Format Nomor Surat</h2><hr><div id="form-wrapper">
<form id="form-rekam" method="POST" action="#">
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamNomor">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>FORMAT NOMOR</label><input class="required" type="text" name="nomor" value="<?php echo $this->data[2]; ?>"></br>
    <label>BAGIAN</label><select class="required" name="bagian">
        <option name="" selected>--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value) { ?>
        <option value="<?php echo $value['kd_bagian'];?>" <?php if($value['kd_bagian']==$this->data[1]) echo 'selected'; ?>> 
            <?php echo strtoupper($value['bagian']);?></option>
        <?php } ?>
    </select></br>
    <label></label><input type="button" onclick="location.href='<?php echo URL;?>admin/rekamNomor'" value="BATAL"><input type="submit" name="submit" value="SIMPAN">
</form></div>

</br>
<hr>
</br>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>BAGIAN</th><th>KODE NOMOR</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->nomor as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['bagian']; ?></td>
        <td><?php echo $value['kd_nomor']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahNomor/<?php echo $value['id_nomor'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusNomor/<?php echo $value['id_nomor'];?>"><input class="btn" type="button" value="HAPUS"></a></td></tr>
    <?php $no++; }?>
</table></div>
