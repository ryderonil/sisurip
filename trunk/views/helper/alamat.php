<table class="CSSTableGenerator">
    <tr><th>No</th><th>Kode Satker</th><th>Nama Satker</th><th>Pilih</th></tr>
    <?php
    $no = 1;

    foreach ($this->alamat as $key => $value) {
        echo "<tr>
               <td>$no</td> 
               <td>$value[kode_satker]</td>
               <td>$value[nama_satker]</td>
               <td><a href=".URL."suratmasuk/rekam/".$value['kode_satker'].">
                   <input class=btn type=button value=PILIH></a></td>
        </tr>";
        $no++;
    }
    ?>
</table>