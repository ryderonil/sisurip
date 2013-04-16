<h2>Rekam Alamat Surat</h2>            
<hr>
<div id="form-wrapper"><form class="admin_form" id="form-rekam" method="POST" action="#">
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>admin/inputRekamAlamat">-->
        <!--<label>KEMENTERIAN/LEMBAGA</label><select></select></br>
        <label>UNIT</label><select></select></br>-->
        
        <label>KODE SATKER</label><input type="text" id="kdsatker" name="kode_satker" 
                                         value="<?php if(isset($this->satker)) echo $this->satker;?>">
        <a href="<?php echo URL;?>helper/pilihsatker"><input type="button" value="+"></a></br>
        <label>NAMA ALAMAT</label><input class="required" type="text" id="nmsatker" name="nama_satker" 
                                         value="<?php if(isset($this->nm_satker)) echo $this->nm_satker;?>">
        <!--<div id="nmsatker"></div>--></br>
        <label>JABATAN</label><input type="text" name="jabatan"></br>
        <label>ALAMAT</label><input class="required" type="text" name="alamat"></br>
        <label>TELEPON</label><input class="number" type="text" name="telepon"></br>
        <label>EMAIL</label><input class="email"type="text" name="email"></br>
        <label></label><input type="reset" value="RESET"><input type="submit" name="submit" value="SIMPAN">
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
</form>
</div>
</br>
<hr>
</br>
<?php if(!is_null($this->data)){?>
<div id="table-wrapper">
<table class="CSSTableGenerator">
    <tr><td>NO</td><td>NAMA ALAMAT</td><td>ALAMAT</td></tr>
    <?php
        $no=1;
        foreach($this->data as $value){
            echo "<tr><td valign=top halign=center>$no</td>
                    <td><a href=".URL."admin/ubahAlamat/$value[id_alamat]>$value[kode_satker]</br> ".  strtoupper($value['jabatan'])." $value[nama_satker]</a></td>
                    <td>$value[alamat]</br>Telp.$value[telepon], Email $value[email]</td></tr>";
            $no++;
        }
    ?>
</table>
</div>
<?php } ?>
    <script type="text/javascript">
    
    $(document).ready(function(){
        $("input").blur(function(){
            $('#nmsatke').fadeOut()
        }); 
    });
    
    function lookup(alamat){
        if(alamat.length == 0){
            $('#nmsatke').fadeOut();
        }else{
            $.post("<?php echo URL;?>helper/cekalamat", {queryString:""+alamat+""},
            function(data){
                $('#nmsatke').fadeIn(500);
                $('#nmsatke').html(data);
            });
        }
    }

    </script>