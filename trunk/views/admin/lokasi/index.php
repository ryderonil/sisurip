<div class="divleft"><h2>Pengaturan Lokasi Penyimpanan Arsip</h2></div>            
        <hr>
        <div id="pesan"></div>
<div class="divleft"><div id="btn-show"></br><input  class="btn write" type="button" name="submit" value="REKAM" onclick="displayform()"></div>
</div><div id="form-wrapper"><form id="form-rekam" >
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>admin/inputRekamLokasi">-->
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
        <div id="wbag"></div>
        <div><label>BAGIAN</label><select id="bagian" id="bagian" name="bagian" onchange="pilihrak(this.value); cekemptyfield(1,this.value);">
        <option value="">--PILIH BAGIAN--</option>
        <?php 
            foreach($this->bagian as $value){
                echo '<option value='.$value['kd_bagian'].'>'.strtoupper($value['bagian']).'</option>';
            }
        ?>
    </select></div></br>
    <label>FILLING/RAK</label><select id="rak" name="rak" onchange="pilihbaris(this.value);">
        <option value="">--PILIH FILLING/RAK--</option>
        <?php 
            //foreach($this->rak as $value){
                //echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            //}
        ?>
    </select></br>
    <label>BARIS</label><select id="baris" name="baris">
        <option value="">--PILIH BARIS--</option>
        <?php 
            //foreach($this->baris as $value){
                //echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            //}
        ?>
    </select></br>
    <div id="wlabel"></div>
    <div><label>LABEL</label><input id="label"  type="text" name="nama" onkeyup="cekemptyfield(2,this.value)"></div></br>
    <!--<label>KETERANGAN</label><input type="text" name="keterangan" width="40"></textarea></br>-->
    <label></label><input class="btn reset" type="reset" value="RESET"><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="cek()"></br>
    <p>Jika filling tidak dipilih, baris tidak dipilih->rekam filling</p>
    <p>Jika filling dipilih, baris tidak dipilih->rekam baris</p>
    <p>Jika filling dipilih, baris dipilih->rekam box</p>
    <p>bagian harus dipilih</p>
</form></div>
</br>
<hr>
</br>
<div id="table-wrapper" style="overflow:scroll; height:400px;"><table class="CSSTableGenerator">
    <tr><td>NO</td><td>BAGIAN</td><td>RAK</td><td>BARIS</td><td>BOX</td><td>STATUS</td><td>AKSI</td></tr>
    <?php 
        foreach($this->lokasi as $data){            
            echo "<tr><td>$data[0]</td>
            <td>$data[1]</td>
            <td>$data[2]</td>
            <td>$data[3]</td>
            <td>$data[4]</td>
            <td>$data[5]</td>
            <td><a href=".URL."admin/ubahLokasi/".$data[6]."><input class='btn edit' type=button value=UBAH></a> | 
                <a href=".URL."admin/ubahStatusLokasi/".$data[6]."/".$data[5]."><input class='btn edit' type=button value=STATUS></a></td></tr>";
        }
    ?>
</table></div>

<script type="text/javascript">

$(document).ready(function(){
        $('#form-wrapper').fadeOut(0);
    });
    
    function displayform(){
        $('#btn-show').fadeOut(500);
        $('#form-wrapper').fadeIn(500);
    }
    
function pilihbaris(rak){

    $.post("<?php echo URL;?>helper/pilihbaris", {queryString:""+rak+""},
            function(data){                
                $('#baris').html(data);
            });
}

function pilihrak(bagian){

    $.post("<?php echo URL;?>helper/pilihrak", {queryString:""+bagian+""},
            function(data){                
                $('#rak').html(data);
            });
}

function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Bagian belum dipilih!</div>'
                    $('#wbag').fadeIn(500);
                    $('#wbag').html(walamat);
                }else{
                    $('#wbag').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Label lokasi harus diisi!</div>'
                    $('#wlabel').fadeIn(500);
                    $('#wlabel').html(wtgl);
                }else{
                    $('#wlabel').fadeOut(500);
                    
                } 
                break;
        }
    }
    
    function cek(){
        var bagian = document.getElementById('bagian').value;
        var label = document.getElementById('label').value;
        var jml = 0;
        if(bagian==''){
            jml++;
            var walamat = '<div id=warning>Bagian belum dipilih!</div>'
            $('#wbag').fadeIn(500);
            $('#wbag').html(walamat);
        }
        
        if(label==''){
            jml++;
            var wtgl = '<div id=warning>Label lokasi harus diisi!</div>'
            $('#wlabel').fadeIn(500);
            $('#wlabel').html(wtgl);
        }
        
        if(jml>0){
            return false;
        }else{
            rekam();
            return true;
        }
    }
    
    function rekam(){
        var bagian = document.getElementById('bagian').value;
        var label = document.getElementById('label').value;
        var rak = document.getElementById('rak').value;
        var baris = document.getElementById('baris').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/inputRekamLokasi',
            data:'bagian='+bagian+
                '&nama='+label+
                '&rak='+rak+
                '&baris='+baris,
            dataType:'json',
            success:function(data){
                if(data.status=='success'){
                    $('#pesan').fadeIn();
                    $('#pesan').html(data.message);
                    window.setTimeout(function(){
                        location.reload(500)
                    }
                    ,3000);
                }else if(data.status=='error'){
                    $('#pesan').fadeIn();
                    $('#pesan').html(data.message);
                }
                
            }
        });
    }



</script>