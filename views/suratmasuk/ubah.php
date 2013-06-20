<div class="divleft"><h2>Ubah Surat Masuk</h2></div>            
<hr>
<div id="pesan"></div>
<?php // foreach($this->data as $key=>$value) { ?>
<div id="form-wrapper"><form id="form-rekam" >
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input id="id_surat" type="hidden" name="id" value="<?php echo $this->data->getId(); ?>"</br>
    <div id="walamat"></div>
    <div><label>ASAL</label><input id="alamat" type="text" size="8" name="asal_surat" value="<?php echo isset($this->alamat)?$this->alamat:$this->data->getAlamat(); ?>" title="isikan kode alamat asal surat(*)" onkeyup="cekemptyfield(1,this.value)">
    <a href="<?php echo URL;?>helper/pilihalamat/3<?php 
                     echo "/".$this->data->getId();?>"><input type="button" name="" value="+"></a></br>
    </div><label>AGENDA</label><input id="agenda" type="text" size="6" name="no_agenda" value="<?php echo $this->data->getAgenda() ?>"></br>
    <label>TANGGAL TERIMA</label><input id="tgl_terima" type="text" name="tgl_terima" value="<?php echo $this->data->getTglTerima() ?>" readonly></br>
    <div id="wtgl"></div>
    <div><label>TANGGAL SURAT</label><input id="datepicker" type="text" name="tgl_surat" value="<?php echo Tanggal::ubahFormatToDatePicker($this->data->getTglSurat()) ?>" onchange="cekemptyfield(2,this.value)" readonly></br>
    </div><div id="wnosurat"></div>
    <div><label>NOMOR SURAT</label><input id="no_surat" type="text" size="40" name="no_surat" value="<?php echo $this->data->getNomor() ?>" title="isikan nomor surat(*)" onkeyup="cekemptyfield(3,this.value)">
    <!--<label class="right"><?php echo $value['no_surat'] ?></label>--></br>
    </div><div id="whal"></div>
    <div><label>PERIHAL</label><textarea id="perihal" cols="30" rows="5" name="perihal" title="isikan perihal surat(*)" onkeyup="cekemptyfield(4,this.value);"><?php echo $this->data->getPerihal() ?></textarea>
<!--        <input id="perihal" type="" size="60" name="perihal" value="<?php echo $this->data->getPerihal() ?>" title="isikan perihal surat(*)" onkeyup="cekemptyfield(4,this.value)">-->
        </br>
    <label>STATUS</label><input id="status" type="" name="status" value="<?php echo $this->data->getStatusSurat() ?>"></br>
    </div><div id="wsifat"></div>
    <div><label>SIFAT</label><select id="sifat" name="sifat" onchange="cekemptyfield(5,this.value)">
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
    </div><div id="wjenis"></div>
    <div><label>JENIS</label><select id="jenis" name="jenis" onchange="cekemptyfield(6,this.value)">
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
    </div><div id="wlampiran"></div>
    <label>LAMPIRAN</label><input id="lampiran" type="" size="5" name="lampiran" value="<?php echo $this->data->getJmlLampiran() ?>" title="isikan jumlah lampiran(*)" onkeyup="cekemptyfield(7,this.value)"></br>
    <label></label><input type="button" class="btn cancel" onclick="location.href='<?php echo URL;?>suratmasuk'" value="BATAL"><input type="button" class="btn save" name="submit" value="SIMPAN" onclick="return selesai();">
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
        cek();
        return true;
    }else{
        return false;
    }
}

function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Isikan kode alamat surat!</div>'
                    $('#walamat').fadeIn(500);
                    $('#walamat').html(walamat);
                }else{
                    $('#walamat').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Isikan tanggal surat mm/dd/yyyy</div>'
                    $('#wtgl').fadeIn(500);
                    $('#wtgl').html(wtgl);
                }else{
                    $('#wtgl').fadeOut(500);
                } 
                break;
            case 3:
                if(content==''){
                    var wtgl = '<div id=warning>Isikan nomor surat!</div>'
                    $('#wnosurat').fadeIn(500);
                    $('#wnosurat').html(wtgl);
                }else{
                    $('#wnosurat').fadeOut(500);
                } 
                break;
            case 4:
                if(content==''){
                    var wtgl = '<div id=warning>Isikan perihal surat!</div>'
                    $('#whal').fadeIn(500);
                    $('#whal').html(wtgl);
                }else{
                    $('#whal').fadeOut(500);
                } 
                break;
            case 5:
                if(content==''){
                    var wtgl = '<div id=warning>Pilih salah satu sifat surat</div>'
                    $('#wsifat').fadeIn(500);
                    $('#wsifat').html(wtgl);
                }else{
                    $('#wsifat').fadeOut(500);
                } 
                break;
            case 6:
                if(content==''){
                    var wtgl = '<div id=warning>Pilih salah satu sifat surat</div>'
                    $('#wjenis').fadeIn(500);
                    $('#wjenis').html(wtgl);
                }else{
                    $('#wjenis').fadeOut(500);
                } 
                break;
            case 7:
                if(content==''){
                    var wtgl = '<div id=warning>Kolom ini harus diisi dengan jumlah lampiran</div>'
                    $('#wlampiran').fadeIn(500);
                    $('#wlampiran').html(wtgl);
                }else if(!checkInput(content)){
                    var wlamp = '<div id=warning>Isikan dengan angka jumlah lampiran</div>'
                    $('#wlampiran').fadeIn(500);
                    $('#wlampiran').html(wlamp);
                }else{
                    $('#wlampiran').fadeOut(500);
                } 
                break;    
        }
    }
    function cek(){
        var agenda = document.getElementById('agenda').value;
        var tgl = document.getElementById('datepicker').value;
        var alamat = document.getElementById('alamat').value;
        var nosurat = document.getElementById('no_surat').value;
        var hal = document.getElementById('perihal').value;
        var sifat = document.getElementById('sifat').value;
        var jenis = document.getElementById('jenis').value;
        var status = document.getElementById('status').value;
        var lampiran = document.getElementById('lampiran').value;
        var jml = 0;
        if(tgl==''){
            jml++;
            var wtgl = '<div id=warning>Isikan tanggal surat mm/dd/yyyy</div>'
            $('#wtgl').fadeIn(500);
            $('#wtgl').html(wtgl);
        }
        
        if(alamat==''){
            jml++;
            var walamat = '<div id=warning>Isikan kode alamat surat!</div>'
            $('#walamat').fadeIn(500);
            $('#walamat').html(walamat);
        }
        
        if(nosurat==''){
            jml++;
            var wtgl = '<div id=warning>Isikan nomor surat!</div>'
            $('#wnosurat').fadeIn(500);
            $('#wnosurat').html(wtgl);
        }
        
        if(hal==''){
            jml++;
            var wtgl = '<div id=warning>Isikan perihal surat!</div>'
            $('#whal').fadeIn(500);
            $('#whal').html(wtgl);
        }
        
        if(jenis==''){
            jml++;
            var wtgl = '<div id=warning>Pilih salah satu jenis surat</div>'
            $('#wjenis').fadeIn(500);
            $('#wjenis').html(wtgl);
        }
        
        if(sifat==''){
            var wtgl = '<div id=warning>Pilih salah satu sifat surat</div>'
            $('#wsifat').fadeIn(500);
            $('#wsifat').html(wtgl);
        }
        
        if(lampiran==''){
            jml++;
            var wlamp = '<div id=warning>Kolom ini harus diisi dengan jumlah lampiran</div>'
            $('#wlampiran').fadeIn(500);
            $('#wlampiran').html(wlamp);
        }else if(!checkInput(lampiran)){
            var wlamp = '<div id=warning>Isikan dengan angka jumlah lampiran</div>'
            $('#wlampiran').fadeIn(500);
            $('#wlampiran').html(wlamp);
        }
        
        if(jml>0){
            return false;
        }else{
            rekam();
            return true;
        }
    }
    //cek input berupa angka
    function checkInput(value) 
    {
        var pola = "^";
        pola += "[0-9]*";
        pola += "$";
        rx = new RegExp(pola);
        
        if(value.match(rx)){
            return true;
        }else{
            return false;
        }
    }

function rekam(){
        var id = document.getElementById('id_surat').value;
        var agenda = document.getElementById('agenda').value;
        var tgl_terima = document.getElementById('tgl_terima').value;
        var tgl = document.getElementById('datepicker').value;
        var alamat = document.getElementById('alamat').value;
        var nosurat = document.getElementById('no_surat').value;
        var hal = document.getElementById('perihal').value;
        var sifat = document.getElementById('sifat').value;
        var jenis = document.getElementById('jenis').value;
        var status = document.getElementById('status').value;
        var lampiran = document.getElementById('lampiran').value;
//        var join = agenda+' '+tgl+' '+alamat+' '+nosurat+' '+hal+' '+sifat+' '+jenis+' '+status+' '+lampiran;
//        alert(join);
        $.ajax({
            type:'POST',
            url:'<?php echo URL; ?>suratmasuk/editSurat',
            data:'id_suratmasuk='+id+
                '&no_agenda='+agenda+
                '&tgl_terima='+tgl_terima+
                '&tgl_surat='+tgl+
                '&asal_surat='+alamat+
                '&no_surat='+nosurat+
                '&perihal='+hal+
                '&sifat='+sifat+
                '&jenis='+jenis+
                '&status='+status+
                '&lampiran='+lampiran,
            success:function(data){
                $('#pesan').fadeIn(500);
                $('#pesan').html(data);
            }
        });
    }


</script>