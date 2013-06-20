<?php
    $html = new Html();
    $form = new Form_Generator();
    $html->div_open('class', 'divleft');
    $html->heading('REKAM LAMPIRAN', 2);
    $html->div_close();
    $html->hr();
    $form = new Form_Generator();
    $html->div_open('class', 'divleft');
    $html->heading('INFORMASI INDUK SURAT', 3);
    $html->div_close();
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
    
    if($this->isAllow){
?>
<div id="pesan"></div>
<div id="form-wrapper"><form id="form-rekam">
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>lampiran/addRekamLampiran"-->
<!--                             enctype="multipart/form-data">-->
    <?php 
        if(isset($this->error)){
            echo "<div id=error>$this->error</div>";
        }elseif(isset($this->success)){
            echo "<div id=success>$this->success</div>";
        }
    ?>
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <input type="hidden" name="jenis" value="<?php echo $this->data[4];?>">
    <div id="wtipe"></div>
    <label>TIPE NASKAH DINAS</label><select id="tipe"  name="tipe" onchange="cekemptyfield(1,this.value);">
        <option value="">--PILIH TIPE NASKAH DINAS--</option>
        <?php
            foreach ($this->tipe as $key=>$value){
                echo "<option value=$value[id_tipe]>$value[kode_naskah] $value[tipe_naskah]</option>";
            }
        ?>
    </select></br>
    <div id="wnomor"></div>
    <label>NOMOR SURAT</label><input id="nomor"  type="text" size="30" name="nomor" onkeyup="cekemptyfield(2,this.value)"></br>
    <div id="wtgl"></div>
    <label>TANGGAL</label><input  id="datepicker" type="text" name="tanggal" onchange="cekemptyfield(3,this.value)" readonly></br>
    <div id="whal"></div>
    <label>HAL/TENTANG</label><input id="hal"  type="text" size="60" name="hal" onkeyup="cekemptyfield(4,this.value)"></br>
    <div id="wasal"></div>
    <label>ASAL/PENANDA TANGAN</label><input id="asal"  type="text" size="40" name="asal" onkeyup="cekemptyfield(5,this.value)"></br>
    <label>KETERANGAN</label><input type="text" name="keterangan" size="60"></br>
    <div id="wfile"></div>
    <label>PILIH FILE</label><input id="file"  type="file" name="upload" onchange="cekemptyfield(6,this.value)"></br>
    <label></label><input type="button" name="submit" value="SIMPAN" onclick="return cek();">
</form></div>
<?php 
    }else{
        echo "<div id=error>Jumlah lampiran yang direkam telah sesuai dengan data rekam surat!</div>";
    }
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
            return false;
    }
    
    function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Tipe Naskah Dinas belum dipilih!</div>'
                    $('#wtipe').fadeIn(500);
                    $('#wtipe').html(walamat);
                }else{
                    $('#wtipe').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Nomor belum diisi!</div>'
                    $('#wnomor').fadeIn(500);
                    $('#wnomor').html(wtgl);
                }else{
                    $('#wnomor').fadeOut(500);
                } 
                break;
            case 3:
                if(content==''){
                    var wtgl = '<div id=warning>Tanggal Naskah belum diisi!</div>'
                    $('#wtgl').fadeIn(500);
                    $('#wtgl').html(wtgl);
                }else{
                    $('#wtgl').fadeOut(500);
                } 
                break;
            case 4:
                if(content==''){
                    var wtgl = '<div id=warning>Perihal Naskah belum diisi!</div>'
                    $('#whal').fadeIn(500);
                    $('#whal').html(wtgl);
                }else{
                    $('#whal').fadeOut(500);
                } 
                break;
            case 5:
                if(content==''){
                    var wtgl = '<div id=warning>Asal/Penandatangan Naskah belum diisi!</div>'
                    $('#wasal').fadeIn(500);
                    $('#wasal').html(wtgl);
                }else{
                    $('#wasal').fadeOut(500);
                } 
                break;
            case 6:
                if(content==''){
                    var wtgl = '<div id=warning>File belum dipilih!</div>'
                    $('#wfile').fadeIn(500);
                    $('#wfile').html(wtgl);
                }else{
                    var csplit = content.split(".");
                    var ext = csplit[csplit.length-1];
                    if(ext!='pdf'){
                        var wfile = '<div id=warning>Sebelum Net File surat harus dalam format pdf!</div>'
                        $('#wfile').fadeIn(200);
                        $('#wfile').html(wfile);
                    }else{
                        $('#wfile').fadeOut(200);
                    }
                } 
                break;
        }
    }
    
    function cek(){
        var tipe = document.getElementById('tipe').value;
        var nomor = document.getElementById('nomor').value;
        var tgl = document.getElementById('datepicker').value;
        var hal = document.getElementById('hal').value;
        var asal = document.getElementById('asal').value;
        var file = document.getElementById('file').value;
        var jml = 0;
        if(tipe==''){
            jml++;
            var wtgl = '<div id=warning>Tipe Naskah Dinas belum dipilih!</div>'
            $('#wtipe').fadeIn(500);
            $('#wtipe').html(wtgl);
        }
        
        if(nomor==''){
            jml++;
            var walamat = '<div id=warning>Nomor belum diisi!</div>'
            $('#wnomor').fadeIn(500);
            $('#wnomor').html(walamat);
        }
        
        if(tgl==''){
            jml++;
            var wtgl = '<div id=warning>Tanggal Naskah belum diisi!</div>'
            $('#wtgl').fadeIn(500);
            $('#wtgl').html(wtgl);
        }
        
        if(asal==''){
            jml++;
            var wtgl = '<div id=warning>Asal/Penandatangan Naskah belum diisi!</div>'
            $('#wasal').fadeIn(500);
            $('#wasal').html(wtgl);
        }
        
        if(hal==''){
            jml++;
            var wtgl = '<div id=warning>Perihal Naskah belum diisi!</div>'
            $('#whal').fadeIn(500);
            $('#whal').html(wtgl);
        }
        
        if(file==''){
            jml++;
            var wtgl = '<div id=warning>File belum dipilih!</div>'
            $('#wfile').fadeIn(500);
            $('#wfile').html(wtgl);
        }else{
            var csplit = file.split(".");
            var ext = csplit[csplit.length-1];
            if(ext!='pdf'){
                jml++;
                var wfile = '<div id=warning>Sebelum Net File surat harus dalam format pdf!</div>'
                $('#wfile').fadeIn(200);
                $('#wfile').html(wfile);
            }
        }
        
        if(jml>0){
            return false;
        }else{
            uploaddata();
            return true;
        }
    }
    
    function uploaddata(){
        var formData = new FormData($('#form-rekam')[0]);
        
        $.ajax({
            url: '<?php echo URL; ?>lampiran/addRekamLampiran',
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

    </script>