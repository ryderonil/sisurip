<?php foreach($this->data as $key=>$value) { ?>
<form method="POST" action="<?php echo URL; ?>suratmasuk/editSurat">
    <input type="hidden" name="id" value="<?php echo $value['id_suratmasuk']; ?>"</br>
    <label>AGENDA</label><input type="text" name="no_agenda" value="<?php echo $value['no_agenda'] ?>"></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima" value="<?php echo $value['tgl_terima'] ?>"></br>
    <label>TANGGAL SURAT</label><input type="text" name="tgl_surat" value="<?php echo $value['tgl_surat'] ?>"></br>
    <label>NOMOR SURAT</label><input type="text" name="no_surat" value="<?php echo $value['no_surat'] ?>"></br>
    <label>ASAL</label><input type="text" name="asal_surat" value="<?php echo $value['asal_surat'] ?>"></br>
    <label>PERIHAL</label><input type="" name="perihal" value="<?php echo $value['perihal'] ?>"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>

<?php } ?>