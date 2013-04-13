<script>
    $(document).ready(function(){
        $("input").blur(function(){
            $('#result').fadeOut()
        }); 
    });
    
    function lookup(alamat){
        if(alamat.length == 0){
            $('#result').fadeOut();
        }else{
            $.post("<?php echo URL;?>helper/alamat", {queryString:""+alamat+""},
            function(data){
                $('#result').fadeIn();
                $('#result').html(data);
            });
        }
    }
</script>
<h2>Pilih Alamat Surat</h2><input type="text" id="alamat" placeholder="cari alamat" onkeyup="lookup(this.value);"><div id="result"></div>
</br>
<hr>
</br>
<table class="CSSTableGenerator">
    <tr><th>No</th><th>Kode Satker</th><th>Nama Satker</th><th>Pilih</th></tr>
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
</table>

<script type="text/javascript">

    function pilih(val){
        
    }



</script>