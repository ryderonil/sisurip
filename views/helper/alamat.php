<script>
    $(document).ready(function(){
        $("input").blur(function(){
            $('#result').fadeOut()
        }); 
    });
    
    function lookup(alamat,tipe){
        if(alamat.length == 0){
            $('#result').fadeOut();
            $('#tb_alamat').fadeIn();
        }else{
            $.post("<?php echo URL;?>helper/alamat", {queryString:""+alamat+","+tipe+""},
            function(data){
                $('#tb_alamat').fadeOut();
                $('#result').fadeIn();
                $('#result').html(data);
            });
        }
    }
</script>
<div class="divleft"><h2>Pilih Alamat Surat</h2><form id="form-search"><input type="text" id="search" placeholder="cari alamat" onkeyup="lookup(this.value,'<?php echo $this->surat;?>');"></form></div>
</br>
<hr>
</br>
<div id="result"></div>
<div id="tb_alamat">
<table class="CSSTableGenerator">
    <tr><td>No</td><td>Kode Satker</td><td>Nama Satker</td><td>Pilih</td></tr>
    <?php
    $no = 1;

    foreach ($this->alamat as $key => $value) {
        echo "<tr>
               <td>$no</td> 
               <td>$value[kode_satker]</td>
               <td>$value[nama_satker]</td>";
        if (isset($this->ids)) {            
            echo "<td><a href=" . URL . $this->surat . "/" . $value['kode_satker'] . "/" . $this->ids . ">
                   <input class=btn type=button value=PILIH onclick=pilih($value[kode_satker]);></a></td>";
        } else {
            echo "<td><a href=" . URL . $this->surat . "/" . $value['kode_satker'] . ">
                   <input class=btn type=button value=PILIH onclick=pilih($value[kode_satker]);></a></td>";
        }

        echo "</tr>";
        $no++;
    }
    ?>
</table></div>

<script type="text/javascript">

    function pilih(val){
        
    }



</script>