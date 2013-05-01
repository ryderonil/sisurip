<?php
    $html = new Html();
    $form = new Form_Generator();
    $html->heading('UBAH DATA LAMPIRAN', 2);
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

<div id="form-wrapper"><form id="form-rekam" method="POST" action="#"
                             enctype="multipart/form-data">
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>lampiran/addRekamLampiran"-->
<!--                             enctype="multipart/form-data">-->
    <?php 
        if(isset($this->error)){
            echo "<div id=error>$this->error</div>";
        }elseif(isset($this->success)){
            echo "<div id=success>$this->success</div>";
        }
    ?>
    <input type="hidden" name="id" value="<?php echo $this->lamp->get('id_lamp');?>">
    <input type="hidden" name="jenis" value="<?php echo $this->lamp->get('jns_surat');?>">
    <input type="hidden" name="id_surat" value="<?php echo $this->lamp->get('id_surat');?>">
    <input type="hidden" name="file" value="<?php echo $this->lamp->get('file');?>">
    <label>TIPE NASKAH DINAS</label><select class="required" name="tipe">
        <option value="0">--PILIH TIPE NASKAH DINAS--</option>
        <?php
            foreach ($this->tipe as $key=>$value){
                if($value['id_tipe']==$this->lamp->get('tipe')){
                   echo "<option value=$value[id_tipe] selected>$value[kode_naskah] $value[tipe_naskah]</option>"; 
                }else{
                   echo "<option value=$value[id_tipe]>$value[kode_naskah] $value[tipe_naskah]</option>"; 
                }
                
            }
        ?>
    </select></br>
    <label>NOMOR SURAT</label><input class="required" type="text" name="nomor" value="<?php echo $this->lamp->get('nomor');?>"></br>
    <label>TANGGAL</label><input class="required" id="datepicker" type="text" name="tanggal" value="<?php echo $this->lamp->get('tanggal');?>"></br>
    <label>HAL/TENTANG</label><input class="required" type="text" name="hal" value="<?php echo $this->lamp->get('hal');?>"></br>
    <label>ASAL/PENANDA TANGAN</label><input class="required" type="text" name="asal" value="<?php echo $this->lamp->get('asal');?>"></br>
    <label>KETERANGAN</label><input type="text" name="keterangan" value="<?php echo $this->lamp->get('keterangan');?>"></br>
    <label>PILIH FILE</label><input type="file" name="upload" ></br>
    <label></label><input type="submit" name="submit" value="SIMPAN" onClick="return selesai();">
</form></div>
<?php 
    
    $mlibur = new Admin_Model();
    
    $libur = $mlibur->getLibur();
//    var_dump($libur);
    
    $count = count($libur);
    $i=0;
//    $datal = array();
    echo "<script type=text/javascript>\n";
//    echo "$(function){\n";
    echo "var holiday=[";
    foreach($libur as $data){
        
        $temp = $data['tgl'];
        $tgl = substr($temp, -2);
        $bln = ((int) substr($temp, 5,2))-1;
        $thn = substr($temp, 0,4);
        if($i<$count){
            echo "new Date($thn,$bln,$tgl).getTime(),";
        }else{
            echo "new Date($thn,$bln,$tgl).getTime()";
        }
//        $datal[] = array('tgl'=>$tgl,'bln'=>$bln,'thn'=>$thn);
        $i++;
    }
    
    echo "]\n";
    echo "$('#datepicker').datepicker({\n";
    echo "minDate: '01/01/2013',\n";
    echo "maxDate: '12/31/2013',\n";
    echo "beforeShowDay: function(date){\n";
    echo "var showDay= true;\n";
    echo "if (date.getDay() == 0 || date.getDay() == 6) {
                showDay = false;
            }";
    
    echo "if ($.inArray(date.getTime(), holiday) > -1) {
                showDay = false;
            }\n";
    echo "return [showDay];\n";
    echo "} \n
            });";
    echo "</script>";
?>
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