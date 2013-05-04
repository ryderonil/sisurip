<?php // foreach($this->data as $key=>$value) { ?>
<div id="form-wrapper"><form method="POST" action="#">
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input type="hidden" name="id" value="<?php echo $this->data->getId(); ?>"</br>
    <label>AGENDA</label><input type="text" name="no_agenda" value="<?php echo $this->data->getAgenda() ?>"></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima" value="<?php echo $this->data->getTglTerima() ?>" readonly></br>
    <label>TANGGAL SURAT</label><input id="datepicker" type="text" name="tgl_surat" value="<?php echo Tanggal::ubahFormatToDatePicker($this->data->getTglSurat()) ?>"></br>
    <label>NOMOR SURAT</label><input type="text" name="no_surat" value="<?php echo $this->data->getNomor() ?>">
    <!--<label class="right"><?php echo $value['no_surat'] ?></label>--></br>
    <label>ASAL</label><input type="text" name="asal_surat" value="<?php echo isset($this->alamat)?$this->alamat:$this->data->getAlamat(); ?>">
    <a href="<?php echo URL;?>helper/pilihalamat/3<?php 
                     echo "/".$this->data->getId();?>"><input type="button" name="" value="+"></a></br>
    <label>PERIHAL</label><input type="" name="perihal" value="<?php echo $this->data->getPerihal() ?>"></br>
    <label>STATUS</label><input type="" name="status" value="<?php echo $this->data->getStatusSurat() ?>"></br>
    <label>SIFAT</label><select name="sifat">
        <?php
        
            foreach($this->sifat as $sifat){
                if($sifat['kode_sifat']==$this->data->getSifat()){
                    echo "<option value=$sifat[kode_sifat] selected>$sifat[sifat_surat]</option>";
                }else{
                    echo "<option value=$sifat[kode_sifat]>$sifat[sifat_surat]</option>";
                }
            }
        ?>
    </select>   
    </br>
    <label>JENIS</label><select name="jenis">
        <?php
        
            foreach($this->jenis as $jenis){
                if($jenis['kode_klassurat']==$this->data->getJenis()){
                    echo "<option value=$jenis[kode_klassurat] selected>$jenis[klasifikasi]</option>";
                }else{
                    echo "<option value=$jenis[kode_klassurat]>$jenis[klasifikasi]</option>";
                }
            }
        ?>
    </select>
    <!--<input type="" name="jenis" value="<?php echo $value['jenis'] ?>">--></br>
    <label>LAMPIRAN</label><input type="" name="lampiran" value="<?php echo $this->data->getJmlLampiran() ?>"></br>
    <label></label><input type="button" onclick="location.href='<?php echo URL;?>suratmasuk'" value="BATAL"><input type="submit" name="submit" value="SIMPAN" onclick="return selesai();">
</form></div>

<?php // } ?>

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
<script type="text/javascript">

function selesai(){
    var answer = 'anda yakin menyimpan perubahan?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
}


</script>