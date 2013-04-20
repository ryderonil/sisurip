<h2>Ubah Jenis Lampiran</h2>
<hr>
<div id="form-wrapper">
<form id="form-rekam" method="POST" action="#">
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamLampiran">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>TIPE NASKAH DINAS</label><input class="required" type="text" name="tipe_naskah" value="<?php echo $this->data[1];?>"></br>
    <label>KODE SURAT</label><input class="required" type="text" name="kode_naskah" value="<?php echo $this->data[2];?>"></br>
    <label></label><input type="submit" name="submit" value="BATAL" onclick="location.href='<?php echo URL;?>admin/rekamJenisLampiran';"><input type="submit" name="submit" value="SIMPAN" onclick="return selesai(1);">
</form></div>

</br>
<hr>
</br>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>TIPE NASKAH</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->lampiran as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>        
        <td><?php echo $value['tipe_naskah']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahLampiran/<?php echo $value['id_tipe'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusLampiran/<?php echo $value['id_tipe'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai(2);" ></a></td></tr>
    <?php $no++; }?>
</table></div>

<script type="text/javascript">

function selesai(num)
{
    if(num==1){
        var answer = confirm ("Anda yakin menyimpan perubahan?")
    }else if(num==2){
        var answer = confirm ("Anda yakin data ini akan dihapus?")
    }
  
    if (answer)
        return true;
    else
        //window.location='<?php echo URL;?>admin/ubahLokasi/<?php echo $this->data[0];?>';
        return false;
    }


</script>