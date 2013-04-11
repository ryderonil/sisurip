<?php
    $html = new Html();
    $form = new Form_Generator();
    $html->heading('REKAM LAMPIRAN', 2);
    $html->hr();    
    $html->heading('INFORMASI INDUK SURAT', 3);
    $html->hr();
    $html->br();
    $html->div_open('id', 'form-wrapper');
    $form->form_open('');
    $form->form_label('NOMOR SURAT');
    $form->form_input(array('value'=>$this->data[1]));
    $html->br();
    $form->form_label('ASAL SURAT');
    $form->form_input(array('value'=>$this->data[2]));
    $html->br();
    $form->form_label('PERIHAL');
    $form->form_input(array('value'=>$this->data[3]));
    $html->br();
    $form->form_close();
    $html->div_close();
    $html->br();
    $html->hr();
    $html->br();
?>

<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL;?>lampiran/addRekamLampiran"
                             enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <input type="hidden" name="jenis" value="<?php echo $this->data[4];?>">
    <label>TIPE NASKAH DINAS</label><select class="required" name="tipe">
        <option value="0">--PILIH TIPE NASKAH DINAS--</option>
        <?php
            foreach ($this->tipe as $key=>$value){
                echo "<option value=$value[id_tipe]>$value[kode_naskah] $value[tipe_naskah]</option>";
            }
        ?>
    </select></br>
    <label>NOMOR SURAT</label><input class="required" type="text" name="nomor"></br>
    <label>TANGGAL</label><input class="required" id="datepicker" type="text" name="tanggal"></br>
    <label>HAL/TENTANG</label><input class="required" type="text" name="hal"></br>
    <label>ASAL/PENANDA TANGAN</label><input class="required" type="text" name="asal"></br>
    <label>KETERANGAN</label><input type="text" name="keterangan"></br>
    <label>PILIH FILE</label><input class="required" type="file" name="upload"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN" onClick="return selesai();">
</form></div>

<script>
    function selesai()
{
    
  var answer = confirm ("Anda yakin menyimpan perubahan?")
    if (answer)
        return true;
    else
        //window.location='cart_view.php';
        return false;
    }
    </script>