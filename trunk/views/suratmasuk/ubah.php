<?php foreach($this->data as $key=>$value) { ?>
<div id="form-wrapper"><form method="POST" action="<?php echo URL; ?>suratmasuk/editSurat">
    <input type="hidden" name="id" value="<?php echo $value['id_suratmasuk']; ?>"</br>
    <label>AGENDA</label><input type="text" name="no_agenda" value="<?php echo $value['no_agenda'] ?>"></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima" value="<?php echo $value['tgl_terima'] ?>" readonly></br>
    <label>TANGGAL SURAT</label><input id="datepicker" type="text" name="tgl_surat" value="<?php echo $value['tgl_surat'] ?>"></br>
    <label>NOMOR SURAT</label><input type="text" name="no_surat" value="<?php echo $value['no_surat'] ?>">
    <!--<label class="right"><?php echo $value['no_surat'] ?></label>--></br>
    <label>ASAL</label><input type="text" name="asal_surat" value="<?php echo isset($this->alamat)?$this->alamat:$value['asal_surat']; ?>">
    <a href="<?php echo URL;?>helper/pilihalamat/3<?php 
                     echo "/".$value['id_suratmasuk'];?>"><input type="button" name="" value="+"></a></br>
    <label>PERIHAL</label><input type="" name="perihal" value="<?php echo $value['perihal'] ?>"></br>
    <label>STATUS</label><input type="" name="status" value="<?php echo $value['status'] ?>"></br>
    <label>SIFAT</label><select name="sifat">
        <?php
        
            foreach($this->sifat as $sifat){
                if($sifat['kode_sifat']==$value['sifat']){
                    echo "<option value=$sifat[kode_sifat] selected>$sifat[sifat_surat]</option>";
                }else{
                    echo "<option value=$sifat[kode_sifat]>$sifat[sifat_surat]</option>";
                }
            }
        ?>
    </select>   
    </br>
    <label>JENIS</label><select name="jenis">
        <?php
        
            foreach($this->jenis as $jenis){
                if($jenis['kode_klassurat']==$value['jenis']){
                    echo "<option value=$jenis[kode_klassurat] selected>$jenis[klasifikasi]</option>";
                }else{
                    echo "<option value=$jenis[kode_klassurat]>$jenis[klasifikasi]</option>";
                }
            }
        ?>
    </select>
    <!--<input type="" name="jenis" value="<?php echo $value['jenis'] ?>">--></br>
    <label>LAMPIRAN</label><input type="" name="lampiran" value="<?php echo $value['lampiran'] ?>"></br>
    <label></label><input type="button" onclick="location.href='<?php echo URL;?>suratmasuk'" value="BATAL"><input type="submit" name="submit" value="SIMPAN" onclick="return selesai();">
</form></div>

<?php } ?>

<script type="text/javascript">

function selesai(){
    var answer = 'anda yakin menyimpan perubahan?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
}


</script>