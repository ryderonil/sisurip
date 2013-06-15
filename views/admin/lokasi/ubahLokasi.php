<div class="divleft"><h2>Pengaturan Lokasi Penyimpanan Arsip</h2></div>            
        <hr>
        <div id="pesan"></div>
<div id="form-wrapper"><form id="form-rekam" method="POST" action="#">
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>admin/updateRekamLokasi">-->
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input id="id" type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <div id="wbag"></div>
    <label>BAGIAN</label><select id="bagian" class="required" id="bagian" name="bagian" onchange="pilihrak(this.value); cekemptyfield(1,this.value)">
        <option value="">--PILIH BAGIAN--</option>
        <?php 
            foreach($this->bagian as $value){
                if($this->data[1]==$value['kd_bagian']){
                    echo '<option value='.$value['kd_bagian'].' selected>'.strtoupper($value['bagian']).'</option>';
                }
                echo '<option value='.$value['kd_bagian'].'>'.strtoupper($value['bagian']).'</option>';
            }
        ?>
    </select></br>
    <label>FILLING/RAK</label><select id="rak" name="rak" onchange="pilihbaris(this.value);">
        <option value="0">--PILIH FILLING/RAK--</option>
        <?php 
            foreach($this->rak as $value){
                if($this->data[2]==$value['id_lokasi']){
                    echo '<option value='.$value['id_lokasi'].' selected>'.$value['lokasi'].'</option>';
                }
                echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            }
        ?>
    </select></br>
    <label>BARIS</label><select id="baris" name="baris">
        <option value="0">--PILIH BARIS--</option>
        <?php 
            foreach($this->baris as $value){
                if($this->data[3]==$value['id_lokasi']){
                    echo '<option value='.$value['id_lokasi'].' selected>'.$value['lokasi'].'</option>';
                }
                echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            }
        ?>
    </select></br>
    <div id="wlabel"></div>
    <label>LABEL</label><input id="label" class="required" type="text" name="nama" value="<?php echo $this->data[4];?>" onkeyup="cekemptyfield(2,this.value)"></br>
    <!--<label>KETERANGAN</label><input type="text" name="keterangan" width="40"></textarea></br>-->
    <label></label><input class="btn cancel" type="reset" onclick="location.href='<?php echo URL;?>admin/rekamLokasi'" name="batal" value="BATAL"><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="return selesai();"></br>
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
    
    function pilihbaris(rak){
        
        $.post("<?php echo URL; ?>helper/pilihbaris", {queryString:""+rak+""},
        function(data){                
            $('#baris').html(data);
        });
    }
    
    function pilihrak(bagian){
        
        $.post("<?php echo URL; ?>helper/pilihrak", {queryString:""+bagian+""},
        function(data){                
            $('#rak').html(data);
        });
    }
    
    function selesai()
    {
        
        var answer = confirm ("Anda yakin menyimpan perubahan?")
        if (answer){
            cek();
            return true;
        }else{
            //window.location='<?php echo URL; ?>admin/ubahLokasi/<?php echo $this->data[0]; ?>';
            return false;
        }
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
            ubah();
            return true;
        }
    }
    
    function ubah(){
        var id = document.getElementById('id').value;
        var bagian = document.getElementById('bagian').value;
        var label = document.getElementById('label').value;
        var rak = document.getElementById('rak').value;
        var baris = document.getElementById('baris').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL; ?>admin/updateRekamLokasi',
            data:'bagian='+bagian+
                '&id='+id+
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