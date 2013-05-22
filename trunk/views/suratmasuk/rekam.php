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
        if(tgl==''){
            var wtgl = '<div id=warning></div>'
            $('#wtgl').fadeIn(500);
            $('#wtgl').html(wtgl);
        }
        
        if(alamat==''){
            var walamat = '<div id=warning></div>'
            $('#walamat').fadeIn(500);
            $('#walamat').html(wtgl);
        }
        
        if(nosurat==''){
            var wtgl = '<div id=warning></div>'
            $('#wnosurat').fadeIn(500);
            $('#wnosurat').html(wtgl);
        }
        
        if(hal==''){
            var wtgl = '<div id=warning></div>'
            $('#whal').fadeIn(500);
            $('#whal').html(wtgl);
        }
        
        if(jenis==''){
            var wtgl = '<div id=warning></div>'
            $('#wjenis').fadeIn(500);
            $('#wjenis').html(wtgl);
        }
        
        if(sifat==''){
            var wtgl = '<div id=warning></div>'
            $('#wsifat').fadeIn(500);
            $('#wsifat').html(wtgl);
        }
        
        if(lampiran==''){
            var wtgl = '<div id=warning></div>'
            $('#wlampiran').fadeIn(500);
            $('#wlampiran').html(wtgl);
        }
    }
    //cek input berupa angka
    function checkInput(obj) 
    {
        var pola = "^";
        pola += "[0-9]*";
        pola += "$";
        rx = new RegExp(pola);
        
        if (!obj.value.match(rx))
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
        }
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
        <label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat" class="required" ></br>
        <label>NOMOR SURAT</label><input id="no_surat" class="required" type="text" name="no_surat"></br>
        <label>ASAL</label><input class="required"  id="alamat" type="text" name="asal_surat" 
                                  value="<?php if(isset($this->alamat)) echo $this->alamat; ?>" onkeyup="lookp(this.value);">
        <a href="<?php echo URL;?>helper/pilihalamat/1"><input type="button" name="" value="+"></a></br>
<!--        onclick="window.open('<?php echo URL?>helper/pilihalamat/1','pilih alamat asal','location=0,toolbar=0,menubar=0,status=0,scrollbar=1,width=500,height=400')"-->
        <div id="result"></div>
        
                                                    <label>PERIHAL</label><!--<input id="perihal" class="required" type="" name="perihal">--><textarea id="perihal" cols="10" rows="10" name="perihal" class="required"></textarea></br>
        <label>STATUS</label><input id="status" type="text" name="status"></br>
        <label>SIFAT</label><select id="sifat" name="sifat" class="required">
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
        <label>JENIS</label><select id="jenis" name="jenis" class="required">
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
        <label>LAMPIRAN</label><input class="required number" id="lampiran" type="text" name="lampiran" onkeyup="return checkInput(this)"></br>    
        <label></label><input type="reset" value="RESET"><input type="button" name="submit" value="SIMPAN" onclick="rekam();">

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
