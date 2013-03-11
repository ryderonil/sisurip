<?php foreach($this->data as $key=>$value) { ?>
<div id="form-wrapper"><form method="POST" action="<?php echo URL; ?>suratmasuk/editSurat">
    <input type="hidden" name="id" value="<?php echo $value['id_suratmasuk']; ?>"</br>
    <label>AGENDA</label><input type="text" name="no_agenda" value="<?php echo $value['no_agenda'] ?>"></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima" value="<?php echo $value['tgl_terima'] ?>" readonly></br>
    <label>TANGGAL SURAT</label><input id="datepicker" type="text" name="tgl_surat" value="<?php echo $value['tgl_surat'] ?>"></br>
    <label>NOMOR SURAT</label><input type="text" name="no_surat" value="<?php echo $value['no_surat'] ?>"></br>
    <label>ASAL</label><input type="text" name="asal_surat" value="<?php echo $value['asal_surat'] ?>"></br>
    <label>PERIHAL</label><input type="" name="perihal" value="<?php echo $value['perihal'] ?>"></br>
    <label>STATUS</label><input type="" name="status" value="<?php echo $value['status'] ?>"></br>
    <label>SIFAT</label><input type="" name="sifat" value="<?php echo $value['sifat'] ?>"></br>
    <label>JENIS</label><input type="" name="jenis" value="<?php echo $value['jenis'] ?>"></br>
    <label>LAMPIRAN</label><input type="" name="lampiran" value="<?php echo $value['lampiran'] ?>"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form></div>

<?php } ?>