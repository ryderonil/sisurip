<h2>Rekam Surat Keluar</h2>            
<hr>
<?php
if (isset($this->data)) {
    $form = new Form_Generator();
    $html = new Html();
    $html->heading('INFORMASI SURAT MASUK :', 3);
    $html->hr();
    $html->br();
    $html->div_open('id', 'form-wrapper');
    //var_dump($html->div_open('id', 'form-wrapper'));
    $form->form_open('suratkeluar');
    $form->form_label('AGENDA SURAT MASUK');
    $form->form_input(array('value' => $this->data[1]));
    $html->br();
    $form->form_label('NOMOR SURAT MASUK');
    $form->form_input(array('value' => $this->data[2]));
    $form->form_close();
    $html->div_close();
    $html->br();
    $html->hr();
    $html->br();
}
?>


<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL; ?>suratkeluar/input" enctype="multipart/form-data">
    <!--<label>AGENDA</label><input type="text" name="no_agenda" value=""></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima"></br>-->
        <?php 
            if(isset($this->success)){
                echo "<div id=success>".$this->success."</div>";
            }
            
            if(isset($this->error)){
                echo "<div id=warning>".$this->error."</div>";
            }
            
        ?>
        <input type="hidden" name="rujukan" value="<?php if (isset($this->data[0])) echo $this->data[0];?>">
        <label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat" class="required" ></br>
        <label>TIPE NASKAH DINAS</label><select name="tipe" id="tipe" class="required">
            <option value="">--PILIH TIPE NASKAH--</option>
            <?php
            foreach ($this->tipe as $key => $value) {
                echo "<option value='" . $value['id_tipe'] . "'>$value[tipe_naskah]</option>";
            }
            ?></select></br>
        <label>NOMOR</label><input type="text" name="nomor" id="nomor"> <input type="button" value="+" onclick=""></br>    
        <label>ALAMAT TUJUAN</label><input class="required" type="text" name="tujuan" value="<?php if (isset($this->alamat)) echo $this->alamat; ?>">
        <a href="<?php echo URL; ?>helper/pilihalamat/2<?php if (isset($this->data)) echo "/" . $this->data[0]; ?>"><input type="button" name="" value="+"></input></a></br>
        <label>PERIHAL</label><input class="required" type="text" name="perihal"></br>
        <label>SIFAT</label><select name="sifat" class="required">
            <option value="" selected>--PILIH SIFAT SURAT--</option>
<?php
foreach ($this->sifat as $key => $value) {
    echo "<option value='" . $value['kode_sifat'] . "'>$value[kode_sifat] $value[sifat_surat]</option>";
}
?>
        </select></br>    
        <label>JENIS</label><select name="jenis" class="required">
            <option value="" selected>--PILIH JENIS SURAT--</option>
<?php
foreach ($this->klas as $key => $value) {
    echo "<option value='" . $value['kode_klassurat'] . "'>$value[kode_klassurat] $value[klasifikasi]</option>";
}
?>
        </select></br>
        <label>LAMPIRAN</label><input type="" name="lampiran"></br>
        <label>FILE SURAT</label><input type="file" name="upload"></br>
        <label></label><input type="reset" value="RESET"><input type="submit" name="submit" value="SIMPAN">
    </form></div>

<script>
        
        function ambilNomor(tipe){
            
        }
</script>