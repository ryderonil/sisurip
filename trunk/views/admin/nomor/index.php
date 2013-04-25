<h2>Tambah Format Nomor Surat</h2>
<hr>
<div id="form-wrapper">
<form id="form-rekam" method="POST" action="#">
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamNomor">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
       
    <label>FORMAT NOMOR</label><input class="required" type="text" name="nomor" onkeyup="keyup();"></br>
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
            <a href="<?php echo URL;?>admin/hapusNomor/<?php echo $value['id_nomor'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai();"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>

<script type="text/javascript">
    
    function selesai()
{
    
        var answer = confirm ("Anda yakin data ini akan dihapus?")
   
  
    if (answer){
        return true;
    }else{
        
        return false;
    }
    
    }
    
    function keyup(){
        $('#error').fadeOut(0);
        $('#success').fadeOut(0);
    }
    
    
    

</script>
