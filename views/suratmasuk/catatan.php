<!-- INFORMASI SURAT -->
<h2>Rekam Disposisi Kasubag/Kasi</h2>
<hr>
</br>
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
        $html->br();
        $form->form_label('DARI');
        $form->form_input(array('value'=>$this->data[3]));
        $html->br();
        $form->form_label('PERIHAL');
        $form->form_textarea(array('name'=>'#'),$this->data[4]);
        $html->br();
        $form->form_close();
        $html->div_close();
        $html->br();
        $html->hr();
        $html->br();
    }
?>

<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL; ?>suratmasuk/rekamCatatan">
        <input type="hidden" name="id_disp" value="<?php echo $this->datad->id_disposisi;?>">
        <input type="hidden" name="bagian" value="<?php echo $this->bagian;?>">
        <label>KEPADA :</label><select  name="peg" class="required">
            <option value="1">--PILIH PEGAWAI--</option>
        </select></br>
        <label>PETUNJUK :</label><textarea class="required" name="catatan" rows="10" cols="50"></textarea></br>
        <label></label><input type="submit" name ="submit" value="SIMPAN" >
            
    </form></div>