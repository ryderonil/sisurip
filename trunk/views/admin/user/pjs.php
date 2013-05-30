<div id="form-wrapper" >
    <?php if(isset($this->warning)) {?>
    <div id="warning"><?php echo $this->warning;?></div>
    <?php } ?>
    <?php if(isset($this->success)) {?>
    <div id="success"><?php echo $this->success;?></div>
    <?php } ?>
    <form id="form-rekam" >
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>admin/inputRekamPjs">-->
    <input type="hidden" name="id" value="<?php echo $this->user;?>">
    <table>
        <tr><td><label>NAMA/NIP</label></td><td><label><font color="black"><?php echo strtoupper($this->nama);?></font></label></td></tr>
        <tr><td colspan="2"><div id="wbag"></div></td></tr>
        <tr><td><label>BAGIAN</label></td><td><select class="required" id="bagian" name="bagian" onchange="cekemptyfield(1,this.value)">
                    <option value="">--PILIH BAGIAN--</option>
                    <?php 
                        foreach ($this->bagian as $val){
                            echo "<option value=$val[id_bagian]>$val[bagian]</option>";
                        }
                    ?>
                </select></td></tr>
        <tr><td colspan="2"><div id="wjabatan"></div></td></tr>
        <tr><td><label>JABATAN</label></td><td><select class="required" id="jabatan" name="jabatan" onchange="cekemptyfield(2,this.value)">
                     <option value="">--PILIH JABATAN--</option>
                     <?php 
                        foreach ($this->role as $val){
                            echo "<option value=$val[id_role]>$val[role]</option>";
                        }
                    ?>
                </select></td></tr>
        <tr><td></td><td><input type="button" name="submit" value="simpan" onclick="cek()"></td></tr>
    </table>        
    
    </form>
</div>
<br>
<div id="table-wrapper">
    <table class="CSSTableGenerator">
        <tr><td>NO</td><td>NAMA</td><td>PJS</td><td>AKSI</td></tr>
        <?php
            $no=1;
            foreach($this->pjs as $value){
                echo "<tr>
                    <td>$no</td>
                    <td>$value[user]</td>
                    <td>";
                if($value['jabatan']=='Pj Eselon IV' AND $value['bagian']=='Subbagian Umum'){
                    echo "Pjs Kasubag Umum";
                }else if($value['jabatan']=='Pj Eselon IV' AND $value['bagian']!='Subbagian Umum'){
                    echo "Pjs Kasi ".$value['bagian'];
                }else{
                    echo "Pjs ".$value['jabatan'];
                }
                echo "</td>
                    <td><a href=".URL."admin/hapuspjs/".$value['id_pjs']."><input type=button onclick='return selesai()' value=HAPUS></a></td>
                    </tr>";
                $no++;
            }
        ?>
    </table>
</div>

<script type="text/javascript">
    function selesai(){
    var answer = 'anda yakin menghapus data jabatan ini?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
}

function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Bagian harus dipilih!</div>'
                    $('#wbag').fadeIn(500);
                    $('#wbag').html(walamat);
                }else{
                    $('#wbag').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Jabatan harus dipilih!</div>'
                    $('#wjabatan').fadeIn(500);
                    $('#wjabatan').html(wtgl);
                }else{
                    $('#wjabatan').fadeOut(500);
                    
                } 
                break;
        }
    }
    
    function cek(){
        var bagian = document.getElementById('bagian').value;
        var jabatan = document.getElementById('jabatan').value;
        var jml = 0;
        if(bagian==''){
            jml++;
            var walamat = '<div id=warning>Bagian harus dipilih!</div>'
            $('#wbag').fadeIn(500);
            $('#wbag').html(walamat);
        }
        
        if(jabatan==''){
            jml++;
            var wtgl = '<div id=warning>Jabatan harus dipilih!</div>'
            $('#wjabatan').fadeIn(500);
            $('#wjabatan').html(wtgl);
        }
        
        $.ajax({
            type:'post',
            url:'<?php echo URL?>admin/cekPejabat',
            data:'bagian='+bagian+
                '&jabatan='+jabatan,
            dataType:'json',
            success:function(data){
                if(data.hasil>=1){
                    jml++;
                    var walamat = '<div id=warning>Non aktifkan pejabat definitif terlebih dahulu!</div>';
                    $('#wbag').fadeIn(500);
                    $('#wbag').html(walamat);
                }
            }
        });
        
        if(jml>0){
            return false;
        }else{
            rekam();
            return true;
        }
    }
    
    function rekam(){
        var bagian = document.getElementById('bagian').value;
        var nomor = document.getElementById('nomor').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/inputRekamNomor',
            data:'bagian='+bagian+
                '&nomor='+nomor,
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