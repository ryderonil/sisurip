<h2>Ubah Surat Keluar</h2>            
<hr>
<?php
if (isset($this->datasm)) {
    $form = new Form_Generator();
    $html = new Html();
    $html->heading('INFORMASI SURAT MASUK :', 3);
    $html->hr();
    $html->br();
    $html->div_open('id', 'form-wrapper');
    //var_dump($html->div_open('id', 'form-wrapper'));
    $form->form_open('suratkeluar');
    $form->form_label('AGENDA SURAT MASUK');
    $form->form_input(array('value' => $this->datasm[1]));
    $html->br();
    $form->form_label('NOMOR SURAT MASUK');
    $form->form_input(array('value' => $this->datasm[2]));
    $form->form_close();
    $html->div_close();
    $html->br();
    $html->hr();
    $html->br();
}
?>


<div id="form-wrapper"><form id="form-rekam" method="POST" action="#">
    <!--<label>AGENDA</label><input type="text" name="no_agenda" value=""></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima"></br>-->
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
        <input type="hidden" name="id" value="<?php echo $this->id;?>">        
        <label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat" class="required" value="<?php echo $this->tgl_surat;?>"></br>
        <label>TIPE NASKAH DINAS</label><select name="tipe" id="tipe">
            <option value="">--PILIH TIPE NASKAH--</option>
            <?php
            foreach ($this->tipe as $key => $value) {
                if($this->tipe1==$value['id_tipe']){
                    echo "<option value='" . $value['id_tipe'] . "' selected>$value[tipe_naskah]</option>";
                }else{
                    echo "<option value='" . $value['id_tipe'] . "'>$value[tipe_naskah]</option>";
                }
                
            }
            ?></select></br>
        <label>NOMOR</label><input type="text" name="nomor" id="nomor" <?php echo $this->no_surat;?>> <input type="button" value="+" onclick="ambilNomor(document.getElementById('tipe').value);"></br>    
        <label>ALAMAT TUJUAN</label><input class="required" type="text" name="tujuan" value="<?php echo isset($this->alamat)?$this->alamat:$this->tujuan; ?>">
        <a href="<?php echo URL; ?>helper/pilihalamat/4<?php if (isset($this->id)) echo "/" . $this->id; ?>"><input type="button" name="" value="+"></input></a></br>
        <label>PERIHAL</label><input class="required" type="text" name="perihal" value="<?php echo $this->perihal;?>"></br>
        <label>SIFAT</label><select name="sifat">
            <option value="" selected>--PILIH SIFAT SURAT--</option>
            <?php
            foreach ($this->sifat as $key => $value) {
                if($this->sifat1==$value['kode_sifat']){
                    echo "<option value='" . $value['kode_sifat'] . "' selected>$value[kode_sifat] $value[sifat_surat]</option>";
                }else{
                    echo "<option value='" . $value['kode_sifat'] . "'>$value[kode_sifat] $value[sifat_surat]</option>";
                }
                
            }
            ?>
        </select></br>    
        <label>JENIS</label><select name="jenis">
            <option value="" selected>--PILIH JENIS SURAT--</option>
            <?php
            foreach ($this->jenis as $key => $value) {
                if($this->jenis1==$value['kode_klassurat']){
                    echo "<option value='" . $value['kode_klassurat'] . "' selected>$value[kode_klassurat] $value[klasifikasi]</option>";
                }else{
                    echo "<option value='" . $value['kode_klassurat'] . "'>$value[kode_klassurat] $value[klasifikasi]</option>";
                }
                
            }
            ?>
        </select></br>
        <label>LAMPIRAN</label><input type="" name="lampiran" value="<?php echo $this->lampiran;?>"></br>
        <label>FILE SURAT</label><input type="file" name="upload"></br>
        <label></label><input type="button" onclick="location.href='<?php echo URL; ?>suratkeluar'" value="BATAL"><input type="submit" name="submit" value="SIMPAN">
    </form></div>
<div id="test"></div>

<script>
        
        function ambilNomor(tipe){
//            document.write(tipe);
            $.post("<?php echo URL;?>suratkeluar/nomorSurat", {queryString:""+tipe+""},
            function(data){
                $('input#nomor').fadeIn(500);
                $('input#nomor').val(data);
//                $('#test').html(data);
            });
        }
</script>