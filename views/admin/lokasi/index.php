<h2>Pengaturan Lokasi Penyimpanan Arsip</h2>            
        <hr>
<div id="form-wrapper"><form id="form-rekam" method="POST" action="#">
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>admin/inputRekamLokasi">-->
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    
    <label>BAGIAN</label><select class="required" id="bagian" name="bagian" onchange="pilihrak(this.value);">
        <option value="0">--PILIH BAGIAN--</option>
        <?php 
            foreach($this->bagian as $value){
                echo '<option value='.$value['kd_bagian'].'>'.strtoupper($value['bagian']).'</option>';
            }
        ?>
    </select></br>
    <label>FILLING/RAK</label><select id="rak" name="rak" onchange="pilihbaris(this.value);">
        <option value="0">--PILIH FILLING/RAK--</option>
        <?php 
            //foreach($this->rak as $value){
                //echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            //}
        ?>
    </select></br>
    <label>BARIS</label><select id="baris" name="baris">
        <option value="0">--PILIH BARIS--</option>
        <?php 
            //foreach($this->baris as $value){
                //echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            //}
        ?>
    </select></br>
    <label>LABEL</label><input class="required" type="text" name="nama"></br>
    <!--<label>KETERANGAN</label><input type="text" name="keterangan" width="40"></textarea></br>-->
    <label></label><input type="reset" value="RESET"><input type="submit" name="submit" value="SIMPAN"></br>
    <p>Jika filling tidak dipilih, baris tidak dipilih->rekam filling</p>
    <p>Jika filling dipilih, baris tidak dipilih->rekam baris</p>
    <p>Jika filling dipilih, baris dipilih->rekam box</p>
    <p>bagian harus dipilih</p>
</form></div>
</br>
<hr>
</br>
<div id="table-wrapper" style="overflow:scroll; height:400px;"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>BAGIAN</th><th>RAK</th><th>BARIS</th><th>BOX</th><th>STATUS</th><th>AKSI</th></tr>
    <?php 
        foreach($this->lokasi as $data){            
            echo "<tr><td>$data[0]</td>
            <td>$data[1]</td>
            <td>$data[2]</td>
            <td>$data[3]</td>
            <td>$data[4]</td>
            <td>$data[5]</td>
            <td><a href=".URL."admin/ubahLokasi/".$data[6]."><input class=btn type=button value=UBAH></a> | 
                <a href=".URL."admin/ubahStatusLokasi/".$data[6]."/".$data[5]."><input class=btn type=button value=STATUS></a></td></tr>";
        }
    ?>
</table></div>

<script type="text/javascript">
    
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

</script>