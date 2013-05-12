<div id="table-wrapper"><table class="CSSTableGenerator">
        <?php
        $no=0;
        foreach ($this->data as $val){
            echo "<tr>";
            if($no>0){
                $temp = explode("@", $val[0]);
                $tgl = Tanggal::tgl_indo($temp[0]);
                echo "<td>$tgl $temp[1]</td>";
            }else{
                echo "<td>$val[0]</td>";
            }
            echo "<td>$val[1]</td>";
            echo "<td>$val[2]</td>";
            echo "<td>$val[3]</td>";
            echo "</tr>";
            $no++;
        }
        ?>
</table></div>