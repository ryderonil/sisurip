<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$html = new Html();
$form = new Form_Generator();
$html->heading('REKAM ARSIP', 2);
$html->hr();
$html->heading('INFORMASI INDUK SURAT', 3);
$html->hr();
$html->br();
$html->div_open('id', 'form-wrapper');
$form->form_open('');
$form->form_label('NOMOR SURAT');
$form->form_input(array('value' => $this->data[1]));
$html->br();
$form->form_label('ASAL SURAT');
$form->form_input(array('value' => $this->data[2]));
$html->br();
$form->form_label('PERIHAL');
$form->form_input(array('value' => $this->data[3]));
$html->br();
$form->form_close();
$html->div_close();
$html->br();
$html->hr();
$html->br();

?>

<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL;?>arsip/rekamArsip">
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>FILLING/RAK</label><select class="required" name="rak">
        <option value="">--PILIH FILLING/RAK/LEMARI--</option>
        <?php
            //foreach ($this->tipe as $key=>$value){
                //echo "<option value=$value[id_tipe]>$value[kode_naskah] $value[tipe_naskah]</option>";
            //}
        ?>
    </select></br>
    <label>BARIS</label><select class="required" name="baris">
        <option value="">--PILIH BARIS--</option>
        <?php
            //foreach ($this->tipe as $key=>$value){
                //echo "<option value=$value[id_tipe]>$value[kode_naskah] $value[tipe_naskah]</option>";
            //}
        ?>
    </select></br>
    <label>BOX/ODNER</label><select class="required" name="box">
        <option value="">--PILIH BOX/ODNER--</option>
        <?php
            //foreach ($this->tipe as $key=>$value){
                //echo "<option value=$value[id_tipe]>$value[kode_naskah] $value[tipe_naskah]</option>";
            //}
        ?>
    </select></br>    
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form></div>