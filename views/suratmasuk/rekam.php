<h2>Rekam Surat Masuk</h2>            
<hr>
<div id="pesan"></div>
<script type="text/javascript">
    
  
    $(document).ready(function(){
        $('#errorr').fadeOut();
//        $('#loading').fadeOut();
        $('#succes').fadeOut();
        $("input").blur(function(){
            $('#result').fadeOut();
            
        }); 
    });
    
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
        /*if (!obj.value.match(rx))
        {
            if (obj.lastMatched)
            {
                obj.value = obj.lastMatched;
            }
            else
            {
                obj.value = "";
            }
        }
        else
        {
            obj.lastMatched = obj.value;
        }*/
    }

    function rekam(){
        var agenda = document.getElementById('agenda').value;
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
            url:'<?php echo URL; ?>suratmasuk/input',
            data:'no_agenda='+agenda+
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
                $.post("<?php echo URL;?>suratmasuk/number", {queryString:""},
                function(nomor){
                    $('input#agenda').val(nomor);
                });
            }
        });
    }
    function lookup(alamat){
        if(alamat.length == 0){
            $('#result').fadeOut();
        }else{
            $.post("<?php echo URL;?>helper/alamat", {queryString:""+alamat+""},
            function(data){
                $('#result').fadeIn();
                $('#result').html(data);
            });
        }
    }
    
</script>
<?php if(isset($this->error)) {?>
<div id="error"><?php echo $this->error;?></div><?php } ?>
<?php if(isset($this->success)) {?><div id="success"><?php echo $this->success;?></div><?php }?>
<div id="form-wrapper"><form id="form-rekam" >
<!--        action="<?php echo URL; ?>suratmasuk/input"-->
        <label>AGENDA</label><input id="agenda" type="text" name="no_agenda" value="<?php echo @$this->agenda; ?>" readonly></br>
        <!--<label>TANGGAL TERIMA</label><input type="text" name="tgl_terima"></br>-->
        <div id="walamat"></div>
        <div><label>ASAL</label><input id="alamat" type="text" name="asal_surat" 
                                  value="<?php if(isset($this->alamat)) echo $this->alamat; ?>" onkeyup="cekemptyfield(1,this.value);" title="isikan kode alamat asal surat(*)"><a href="<?php echo URL;?>helper/pilihalamat/1"><input type="button" name="" value="+"></a></br>
        </div><div id="wtgl"></div>
        <div><label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat" title="tanggal surat (*)" onkeyup="cekemptyfield(2,this.value);" onchange="cekemptyfield(2,this.value);" readonly></br>
        </div><div id="wnosurat"></div>
        <div><label>NOMOR SURAT</label><input id="no_surat" type="text" name="no_surat" title="isikan nomor surat(*)" onkeyup="cekemptyfield(3,this.value);"></br>
        
<!--        onclick="window.open('<?php echo URL?>helper/pilihalamat/1','pilih alamat asal','location=0,toolbar=0,menubar=0,status=0,scrollbar=1,width=500,height=400')"-->
        <div id="result"></div>
        </div><div id="whal"></div>
        <label>PERIHAL</label><!--<input id="perihal" class="required" type="" name="perihal">--><textarea id="perihal" cols="10" rows="10" name="perihal" title="isikan perihal surat(*)" onkeyup="cekemptyfield(4,this.value);"></textarea></br>
        <div><label>STATUS</label><input id="status" type="text" name="status" title="isikan status surat"></br>
        </div><div id="wsifat"></div>
        <div><label>SIFAT</label><select id="sifat" name="sifat" onchange="cekemptyfield(5,this.value);">
            <option value="">--PILIH SIFAT SURAT--</option>
            <?php            
                foreach($this->sifat as $value){
                    //if($value[kode_sifat]=='BS') {
                       // echo "<option value=$value[kode_sifat] selected>$value[sifat_surat]</option>";
                    //}else{
                        echo "<option value=$value[kode_sifat]>$value[sifat_surat]</option>";
                    //}
                    
                }
            ?>
        </select></br>
        </div><div id="wjenis"></div>
        <div><label>JENIS</label><select id="jenis" name="jenis" onchange="cekemptyfield(6,this.value);">
            <option value="">--PILIH JENIS SURAT--</option>
            <?php 
                foreach($this->jenis as $value){
                    //if($value[kode_klassurat]=='BS') {
                        //echo "<option value=$value[kode_klassurat] selected>$value[klasifikasi]</option>";
                    //}else{
                        echo "<option value=$value[kode_klassurat]>$value[klasifikasi]</option>";
                    //}
                    
                }
            ?>
        </select></br>
        </div><div id="wlampiran"></div>
        <label>LAMPIRAN</label><input id="lampiran" type="text" name="lampiran" onkeyup="cekemptyfield(7,this.value);" title="isikan jumlah lampiran(*)"></br>    
        <label></label><input type="reset" class="btn reset" value="RESET"><input type="button" class="btn save" name="submit" value="SIMPAN" onclick="return cek();">
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
