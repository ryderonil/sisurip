<!--<form method="POST" action="<?php echo URL; ?>/helper/pilihsatker" >
    <input type="text" name="cari"><input type="submit" name="submit" value="CARI">
</form>-->
<form>
    <select id="lokasi" onchange="lookupkab(this.value);">
        <option>-- PILIH WILAYAH --</option>
        <?php
        foreach ($this->lokasi as $value) {
            echo "<option value=$value[kdlokasi]>$value[nmlokasi]</option>";
        }
        ?>
    </select>
    <select id="kab" onchange="lookuplokasi(this.value,document.getElementById('lokasi').value)"> 
        <option>-- PILIH KAB/ KOTA --</option>
        <?php
        foreach ($this->kab as $value) {
            echo "<option value=$value[kdkabkota]>$value[nmkabkota]</option>";
        }
        ?>
    </select>
    <!--<select id="dept" onchange="lookuplokasi(this.value)"> 
        <option>-- PILIH KEMENT/LEMBAGA --</option>
    <?php
    foreach ($this->dept as $value) {
        echo "<option value=$value[kddept]>$value[nmdept]</option>";
    }
    ?>
    </select>-->

</form>

<hr>
<br>
<div id="table-wrapper"><table class="CSSTableGenerator" id="table">
        <tr><td>NO</td><td>KODE</td><td>NAMA SATKER</td><td>AKSI</td></tr>
        <?php
        $no = 1;
        foreach ($this->data as $value) {
            echo "<tr><td>$no</td>
                    <td>$value[kdsatker]</td>
                    <td>$value[nmsatker]</td>
                    <td><a href=" . URL . "admin/rekamAlamat/$value[kdsatker]><input id=btn type=button value=PILIH></a></td></tr>";
            $no++;
        }
        ?>
    </table></div>

<script type="text/javascript">

    function lookuplokasi(val,value2){
        $.post("<?php echo URL; ?>helper/lookupSatker", {queryString:""+val+","+value2+""},
        function(data){                
            $('#table').fadeIn();
            $('#table').html(data);
        });
        
    }

    function lookupkab(value1){        
        $.post("<?php echo URL; ?>helper/lookupkab", {queryString:""+value1+""},
        function(data){                
         $('#kab').fadeIn();
         $('#kab').html(data);
        });      
    }  
    

</script>
