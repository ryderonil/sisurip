<?php foreach($this->dataSurat as $key=>$value) { ?>
<form method="POST" action="<?php echo URL; ?>suratmasuk/edit/<?php echo $value['id_suratmasuk']; ?>">
    <label>AGENDA</label><input type="text" name="no_agenda" value="<?php echo $value['no_agenda'] ?>" readonly></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima" value="<?php echo $value['tgl_terima'] ?>" readonly></br>
    <label>TANGGAL SURAT</label><input type="text" name="tgl_surat" value="<?php echo $value['tgl_surat'] ?>" readonly></br>
    <label>NOMOR SURAT</label><input type="text" name="no_surat" value="<?php echo $value['no_surat'] ?>" readonly></br>
    <label>ASAL</label><input type="text" name="asal_surat" value="<?php echo $value['asal_surat'] ?>" readonly></br>
    <label>PERIHAL</label><input type="" name="perihal" value="<?php echo $value['perihal'] ?>" readonly></br>
    <label></label><input type="submit" name="submit" value="UBAH">
</form>
<?php } ?>
