<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$html = new Html();
$form = new Form_Generator();
$html->heading('REKAM ARSIP', 2);
$html->hr();
$html->heading('INFORMASI INDUK SURAT', 3);
$html->hr();
$html->br();
$html->div_open('id', 'pesan');
$html->div_close();
$html->div_open('id', 'form-wrapper');
$form->form_open('');
$form->form_label('NOMOR SURAT');
$form->form_input(array('value' => $this->data[1]));
$html->br();
$form->form_label('ASAL SURAT');
$form->form_input(array('value' => $this->data[2]));
$html->br();
$form->form_label('PERIHAL');
$form->form_input(array('value' => $this->data[3]));
$html->br();
$form->form_close();
$html->div_close();
$html->br();
$html->hr();
$html->br();

?>

<div id="pesan"></div>
<div id="form-wrapper"><form id="form-rekam" >
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>arsip/rekamArsip">-->
        <?php 
        if(isset($this->error)){
            echo "<div id=error>$this->error</div>";
        }elseif(isset($this->success)){
            echo "<div id=success>$this->success</div>";
        }
        if(isset($this->ar)){
    ?>
    <input id="id_arsip" type="hidden" name="id_arsip" value="<?php echo $this->ar['id_arsip'];?>">
        <?php }?>
    <input id="id_surat" type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <input id="tipe" type="hidden" name="tipe" value="<?php echo $this->tipe;?>">
    <?php if(isset($this->warning)) { ?><div id="warning"><?php echo $this->warning;?></div><?php } ?>
<?php if(!isset($this->warning)) { ?>
    <div id="wrak"></div>
    <div><label>FILLING/RAK</label><select class="required" id="rak" name="rak" onchange="pilihbaris(this.value); cekemptyfield(1,this.value)">
        <option value="">--PILIH FILLING/RAK/LEMARI--</option>
        <?php 
        foreach ($this->rak as $key=>$value){
            if(isset($this->ar['rak'])){
                if($this->ar['rak']==$value['id_lokasi']){
                    echo "<option value='".$value['id_lokasi']."' selected>$value[bagian] $value[lokasi]</option>";
                }else{
                    echo "<option value='".$value['id_lokasi']."'>$value[bagian] $value[lokasi]</option>";
                }
            }else{
                echo "<option value='".$value['id_lokasi']."'>$value[bagian] $value[lokasi]</option>";
            }
            
        }
        ?>
    </select></br>
    </div><div id="wbaris"></div>
    <div><label>BARIS</label><select class="required" id="baris" name="baris" onchange="pilihbox(this.value);cekemptyfield(2,this.value)">
        <option value="">--PILIH BARIS--</option>
        <?php
        foreach ($this->baris as $value){
            if(isset($this->ar['baris'])){
                if($this->ar['baris']==$value['id_lokasi']){
                    echo "<option value='".$value['id_lokasi']."' selected>$value[bagian] $value[lokasi]</option>";
                }else{
                    echo "<option value='".$value['id_lokasi']."'>$value[bagian] $value[lokasi]</option>";
                }
            }
        }
            
            //foreach ($this->baris as $key=>$value){
            //echo "<option value='".$value['id_lokasi']."'>$value[lokasi]</option>";
        //}
        
        ?>
    </select></br>
    </div><div id="wbox"></div>
    <div><label>BOX/ODNER</label><select class="required" id="box" name="box" onchange="cekemptyfield(3,this.value)">
        <option value="">--PILIH BOX/ODNER--</option>
        <?php
        foreach ($this->box as $value){
            if(isset($this->ar['box'])){
                if($this->ar['box']==$value['id_lokasi']){
                    echo "<option value='".$value['id_lokasi']."' selected>$value[bagian] $value[lokasi]</option>";
                }else{
                    echo "<option value='".$value['id_lokasi']."'>$value[bagian] $value[lokasi]</option>"; 
                }
            }
        }
            //foreach ($this->box as $key=>$value){
            //echo "<option value='".$value['id_lokasi']."'>$value[lokasi]</option>";
        //}
        ?>
    </select></br>
    </div><div id="wklas"></div>
    <div><label>KLASIFIKASI</label><select class="required" id="klas" name="klas" onchange="cekemptyfield(4,this.value)">
        <option value="">--PILIH KLASIFIKASI ARSIP--</option>
        <?php
        foreach ($this->klas as $value){
            if(isset($this->ar['klas'])){
                if($this->ar['klas']==$value['id_klasarsip']){
                    echo "<option value='".$value['id_klasarsip']."' selected>$value[klasifikasi]</option>";
                }else{
                    echo "<option value='".$value['id_klasarsip']."'>$value[klasifikasi]</option>"; 
                }
            }else{
                echo "<option value='".$value['id_klasarsip']."'>$value[klasifikasi]</option>";
            }
        }
            //foreach ($this->box as $key=>$value){
            //echo "<option value='".$value['id_lokasi']."'>$value[lokasi]</option>";
        //}
        ?>
    </select></div></br>
    <label></label><input type="button" name="submit" value="SIMPAN" onclick="
        <?php if(isset($this->ar)) {?>
            return cek(2);
        <?php }else{ ?>
            return cek(1);
        <?php } ?> "> 
        
</form></div> <?php } ?>

<script type="text/javascript">
    
function pilihbaris(rak){

    $.post("<?php echo URL;?>helper/pilihbaris", {queryString:""+rak+""},
            function(data){                
                $('#baris').html(data);
            });
}

function pilihbox(baris){

    $.post("<?php echo URL;?>helper/pilihbox", {queryString:""+baris+""},
            function(data){                
                $('#box').html(data);
            });
}

function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Rak belum dipilih!</div>'
                    $('#wrak').fadeIn(500);
                    $('#wrak').html(walamat);
                }else{
                    $('#wrak').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Baris belum dipilih!</div>'
                    $('#wbaris').fadeIn(500);
                    $('#wbaris').html(wtgl);
                }else{
                    $('#wbaris').fadeOut(500);
                } 
                break;
            case 3:
                if(content==''){
                    var wtgl = '<div id=warning>Box/Odner belum dipilih!</div>'
                    $('#wbox').fadeIn(500);
                    $('#wbox').html(wtgl);
                }else{
                    $('#wbox').fadeOut(500);
                } 
                break;
            case 4:
                if(content==''){
                    var wtgl = '<div id=warning>Klasifikasi Arsip belum dipilih!</div>'
                    $('#wklas').fadeIn(500);
                    $('#wklas').html(wtgl);
                }else{
                    $('#wklas').fadeOut(500);
                } 
                break;
        }
    }
    
    function cek(num){
        var rak = document.getElementById('rak').value;
        var baris = document.getElementById('baris').value;
        var box = document.getElementById('box').value;
        var klas = document.getElementById('klas').value;
        var jml = 0;
        if(rak==''){
            jml++;
            var wtgl = '<div id=warning>Rak belum dipilih!</div>'
            $('#wrak').fadeIn(500);
            $('#wrak').html(wtgl);
        }
        
        if(baris==''){
            jml++;
            var walamat = '<div id=warning>Baris belum dipilih!</div>'
            $('#wbaris').fadeIn(500);
            $('#wbaris').html(walamat);
        }
        
        if(box==''){
            jml++;
            var wtgl = '<div id=warning>Box/Odner belum dipilih!</div>'
            $('#wbox').fadeIn(500);
            $('#wbox').html(wtgl);
        }
        
        if(klas==''){
            jml++;
            var wtgl = '<div id=warning>Klasifikasi Arsip belum dipilih!</div>'
            $('#wklas').fadeIn(500);
            $('#wklas').html(wtgl);
        }
        
        if(jml>0){
            return false;
        }else{
            if(num==1){
               rekam(); 
            }else if(num==2){
               return selesai(); 
            }
            
            return true;
        }
    }

function rekam(){
    var box = document.getElementById('box').value;
    var id_surat = document.getElementById('id_surat').value;
    var tipe_surat = document.getElementById('tipe').value;
    var jenis = document.getElementById('klas').value;
    
    $.ajax({
       type:"POST",
       url:'<?php echo URL;?>arsip/rekamArsip',
       data:'box='+box+
            '&id='+id_surat+
            '&tipe='+tipe_surat+
            '&jenis='+jenis,
        success:function(data){
            $('#pesan').fadeIn(500);
            $('#pesan').html(data);
        }
    });
}

function ubah(){
    var id_arsip = document.getElementById('id_arsip').value;
    var box = document.getElementById('box').value;
    var id_surat = document.getElementById('id_surat').value;
    var tipe_surat = document.getElementById('tipe').value;
    var jenis = document.getElementById('klas').value;
    
    $.ajax({
       type:"POST",
       url:'<?php echo URL;?>arsip/ubahArsip',
       data:'box='+box+
            '&id='+id_surat+
            '&id_arsip='+id_arsip+
            '&tipe='+tipe_surat+
            '&jenis='+jenis,
        success:function(data){
            $('#pesan').fadeIn(500);
            $('#pesan').html(data);
        }
    });
}

function selesai(){
    
    var answer = 'Anda yakin akan menyimpan perubahan data arsip?';
    
    if(confirm(answer)){
        ubah();
        return true;
    }else{
        return false;
    }
}

</script>

