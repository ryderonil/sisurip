<h2>Rekam Surat Keluar</h2>            
        <hr>
<?php
    if(isset($this->data)){
        $form = new Form_Generator();
        $html = new Html();
        $html->heading('INFORMASI SURAT MASUK :', 3);
        $html->hr();
        $html->br();
        $html->div_open('id', 'form-wrapper');
        //var_dump($html->div_open('id', 'form-wrapper'));
        $form->form_open('suratkeluar');        
        $form->form_label('AGENDA SURAT MASUK');
        $form->form_input(array('value'=>$this->data[1]));
        $html->br();
        $form->form_label('NOMOR SURAT MASUK');
        $form->form_input(array('value'=>$this->data[2]));
        $form->form_close();
        $html->div_close();
        $html->br();
        $html->hr();
        $html->br();
    }

?>
        
        
<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL; ?>suratmasuk/input">
    <!--<label>AGENDA</label><input type="text" name="no_agenda" value=""></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima"></br>-->
    <label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat" class="required" ></br>
    <label>TIPE NASKAH DINAS</label><select name="tipe">
        <option value="">--PILIH TIPE NASKAH--</option>
        <?php 
        foreach ($this->tipe as $key=>$value){
            echo "<option value='".$value['id_tipe']."'>$value[tipe_naskah]</option>";
        }
        ?></select></br>
    <label>ALAMAT TUJUAN</label><input class="required" type="text" name="asal_surat">
        <input type="button" name="rekam"></input></br>
    <label>PERIHAL</label><input class="required" type="" name="perihal"></br>
    <label>SIFAT</label><select name="sifat">
        <option value="">--PILIH SIFAT SURAT--</option>
        <?php 
        foreach ($this->sifat as $key=>$value){
            echo "<option value='".$value['id_sifat']."'>$value[kode_sifat] $value[sifat_surat]</option>";
        }
        ?>
    </select></br>    
    <label>JENIS</label><select name="jenis">
        <option value="">--PILIH JENIS SURAT--</option>
        <?php 
        foreach ($this->klas as $key=>$value){
            echo "<option value='".$value['id_klassurat']."'>$value[kode_klassurat] $value[klasifikasi]</option>";
        }
        ?>
    </select></br>
    <label>LAMPIRAN</label><input type="" name="lampiran"></br>    
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form></div>