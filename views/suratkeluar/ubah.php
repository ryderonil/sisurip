<h2>Ubah Surat Keluar</h2>            
<hr>
<div id="pesan"></div>
<?php
if (isset($this->datasm)) {
    $form = new Form_Generator();
    $html = new Html();
    $html->heading('INFORMASI SURAT MASUK :', 3);
    $html->hr();
    $html->br();
    $html->div_open('id', 'form-wrapper');
    //var_dump($html->div_open('id', 'form-wrapper'));
    $form->form_open('suratkeluar');
    $form->form_label('AGENDA SURAT MASUK');
    $form->form_input(array('value' => $this->datasm[1]));
    $html->br();
    $form->form_label('NOMOR SURAT MASUK');
    $form->form_input(array('value' => $this->datasm[2]));
    $form->form_close();
    $html->div_close();
    $html->br();
    $html->hr();
    $html->br();
}
?>


<div id="form-wrapper"><form id="form-rekam" method="POST" action="#" enctype="multipart/form-data">
    <!--<label>AGENDA</label><input type="text" name="no_agenda" value=""></br>
    <label>TANGGAL TERIMA</label><input type="text" name="tgl_terima"></br>-->
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
        <input type="hidden" name="id" value="<?php echo $this->id;?>">
        <div id="walamat"></div>
        <div><label>ALAMAT TUJUAN</label><input id="alamat"  type="text" name="tujuan" value="<?php echo isset($this->alamat)?$this->alamat:$this->tujuan; ?>" title="isikan kode alamat tujuan(*)" onkeyup="cekemptyfield(1,this.value)">
        <a href="<?php echo URL; ?>helper/pilihalamat/4<?php if (isset($this->id)) echo "/" . $this->id; ?>"><input type="button" name="" value="+"></input></a></br>
        </div><div id="wtgl"></div>
        <label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat"  value="<?php echo $this->tgl_surat;?>" onchange="cekemptyfield(2,this.value)" readonly></br>
        <div id="wtipe"></div>
        <label>TIPE NASKAH DINAS</label><select name="tipe" id="tipe" onchange="cekemptyfield(7,this.value)">
            <option value="">--PILIH TIPE NASKAH--</option>
            <?php
            foreach ($this->tipe as $key => $value) {
                if($this->tipe1==$value['id_tipe']){
                    echo "<option value='" . $value['id_tipe'] . "' selected>$value[tipe_naskah]</option>";
                }else{
                    echo "<option value='" . $value['id_tipe'] . "'>$value[tipe_naskah]</option>";
                }
                
            }
            ?></select></br>
        <label>NOMOR</label><input type="text" name="nomor" id="nomor" value="<?php echo $this->no_surat;?>"> <input type="button" value="+" onclick="ambilNomor(document.getElementById('tipe').value);"></br>    
        <div id="whal"></div>
        <label>PERIHAL</label><input id="perihal"  type="text" name="perihal" value="<?php echo $this->perihal;?>" title="isikan perihal surat(*)" onkeyup="cekemptyfield(3,this.value)"></br>
        <div id="wsifat"></div>
        <label>SIFAT</label><select name="sifat" id="sifat" onchange="cekemptyfield(4,this.value)">
            <option value="" selected>--PILIH SIFAT SURAT--</option>
            <?php
            foreach ($this->sifat as $key => $value) {
                if($this->sifat1==$value['kode_sifat']){
                    echo "<option value='" . $value['kode_sifat'] . "' selected>$value[kode_sifat] $value[sifat_surat]</option>";
                }else{
                    echo "<option value='" . $value['kode_sifat'] . "'>$value[kode_sifat] $value[sifat_surat]</option>";
                }
                
            }
            ?>
        </select></br>
        <div id="wjenis"></div>
        <label>JENIS</label><select name="jenis" id="jenis" onchange="cekemptyfield(5,this.value)">
            <option value="" selected>--PILIH JENIS SURAT--</option>
            <?php
            foreach ($this->jenis as $key => $value) {
                if($this->jenis1==$value['kode_klassurat']){
                    echo "<option value='" . $value['kode_klassurat'] . "' selected>$value[kode_klassurat] $value[klasifikasi]</option>";
                }else{
                    echo "<option value='" . $value['kode_klassurat'] . "'>$value[kode_klassurat] $value[klasifikasi]</option>";
                }
                
            }
            ?>
        </select></br>
        <div id="wlampiran"></div>
        <label>LAMPIRAN</label><input id="lampiran" type="" name="lampiran" value="<?php echo $this->lampiran;?>" title="isikan jumlah lampiran(*)" onkeyup="cekemptyfield(6,this.value)"></br>
        <label>FILE SURAT</label><input type="file" name="upload"></br>
        <label></label><input type="button" onclick="location.href='<?php echo URL; ?>suratkeluar'" value="BATAL"><input type="submit" name="submit" value="SIMPAN" onclick="return selesai();">
    </form></div>
<div id="test"></div>

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
        
        function ambilNomor(tipe){
//            document.write(tipe);
            $.post("<?php echo URL;?>suratkeluar/nomorSurat", {queryString:""+tipe+""},
            function(data){
                $('input#nomor').fadeIn(500);
                $('input#nomor').val(data);
//                $('#test').html(data);
            });
        }
        
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
                    var wtgl = '<div id=warning>Isikan perihal surat!</div>'
                    $('#whal').fadeIn(500);
                    $('#whal').html(wtgl);
                }else{
                    $('#whal').fadeOut(500);
                } 
                break;
            case 4:
                if(content==''){
                    var wtgl = '<div id=warning>Pilih salah satu sifat surat</div>'
                    $('#wsifat').fadeIn(500);
                    $('#wsifat').html(wtgl);
                }else{
                    $('#wsifat').fadeOut(500);
                } 
                break;
            case 5:
                if(content==''){
                    var wtgl = '<div id=warning>Pilih salah satu jenis surat</div>'
                    $('#wjenis').fadeIn(500);
                    $('#wjenis').html(wtgl);
                }else{
                    $('#wjenis').fadeOut(500);
                } 
                break;
            case 6:
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
            case 7:
                if(content==''){
                    var wtgl = '<div id=warning>Pilih salah satu tipe surat</div>'
                    $('#wtipe').fadeIn(500);
                    $('#wtipe').html(wtgl);
                }else{
                    $('#wtipe').fadeOut(500);
                } 
                break;
        }
    }
    
    function cek(){
        var tgl = document.getElementById('datepicker').value;
        var alamat = document.getElementById('alamat').value;
        var hal = document.getElementById('perihal').value;
        var sifat = document.getElementById('sifat').value;
        var jenis = document.getElementById('jenis').value;
        var tipe = document.getElementById('tipe').value;
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
        
        if(hal==''){
            jml++;
            var wtgl = '<div id=warning>Isikan perihal surat!</div>'
            $('#whal').fadeIn(500);
            $('#whal').html(wtgl);
        }
        
        if(tipe==''){
            jml++;
            var wtgl = '<div id=warning>Pilih salah satu tipe surat</div>'
            $('#wtipe').fadeIn(500);
            $('#wtipe').html(wtgl);
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
    
    function uploaddata(){
        var formData = new FormData($('#form-rekam')[0]);
        
        $.ajax({
            url: '<?php echo URL; ?>suratkeluar/editSurat',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                $('#pesan').html(data)
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        return false;
    }
    
    function rekam(){
        var id = document.getElementById('id').value;
        var tgl = document.getElementById('datepicker').value;
        var alamat = document.getElementById('alamat').value;
        var nosurat = document.getElementById('no_surat').value;
        var hal = document.getElementById('perihal').value;
        var tipe = document.getElementById('tipe').value;
        var sifat = document.getElementById('sifat').value;
        var jenis = document.getElementById('jenis').value;
        var lampiran = document.getElementById('lampiran').value;
        //        var join = agenda+' '+tgl+' '+alamat+' '+nosurat+' '+hal+' '+sifat+' '+jenis+' '+status+' '+lampiran;
        //        alert(join);
        $.ajax({
            type:'POST',
            url:'<?php echo URL; ?>suratkeluar/editSurat',
            data:'id_suratkeluar='+id+
                '&tgl_surat='+tgl+
                '&tujuan='+alamat+
                '&no_surat='+nosurat+
                '&perihal='+hal+
                '&sifat='+sifat+
                '&jenis='+jenis+
                '&tipe='+tipe+
                '&lampiran='+lampiran,
            success:function(data){
                $('#pesan').fadeIn(500);
                $('#pesan').html(data);
            }
        });
    }
</script>