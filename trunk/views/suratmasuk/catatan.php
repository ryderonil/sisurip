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

<div id="form-wrapper"><form id="form-rekam" method="POST" action="#">
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
            
            if(isset($this->data[0])){
                
            
        ?>
        <input type="hidden" name="id_surat" value="<?php echo $this->data[0];?>">
        <input type="hidden" name="id_disp" value="<?php echo $this->datad->id_disposisi;?>">
        <input type="hidden" name="bagian" value="<?php echo $this->bagian;?>">
        <label>KEPADA :</label><select  name="peg" class="required">
            <option value="">--PILIH PEGAWAI--</option>
            <?php 
                foreach ($this->peg as $val){
                    echo "<option value=$val[id_user]>$val[namaPegawai]</option>";
                }
            ?>
        </select></br>
        <label>PETUNJUK :</label><br><textarea id="input" class="required" name="catatan" rows="10" cols="50"></textarea></br>
        <label></label><input type="submit" name ="submit" value="SIMPAN" >
            
        <?php }else{
            echo "<div id=warning>Surat belum didisposisi Kepala Kantor, Anda tidak dapat memberikan disposisi!</div>";
        } ?>
        
        
    </form></div>