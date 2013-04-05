<div id="form-wrapper" >
    <?php if(isset($this->warning)) {?>
    <div id="warning"><?php echo $this->warning;?></div>
    <?php } ?>
    <?php if(isset($this->success)) {?>
    <div id="success"><?php echo $this->success;?></div>
    <?php } ?>
    <form method="POST" action="<?php echo URL;?>admin/inputRekamPjs">
    <input type="hidden" name="id" value="<?php echo $this->user;?>">
    <table>
        <tr><td><label>NAMA/NIP</label></td><td><label><font color="black"><?php echo strtoupper($this->nama);?></font></label></td></tr>
        <tr><td><label>BAGIAN</label></td><td><select id="" name="bagian">
                    <option value="">--PILIH BAGIAN--</option>
                    <?php 
                        foreach ($this->bagian as $val){
                            echo "<option value=$val[id_bagian]>$val[bagian]</option>";
                        }
                    ?>
                </select></td></tr>
        <tr><td><label>JABATAN</label></td><td><select id="" name="jabatan">
                     <option value="">--PILIH JABATAN--</option>
                     <?php 
                        foreach ($this->role as $val){
                            echo "<option value=$val[id_role]>$val[role]</option>";
                        }
                    ?>
                </select></td></tr>
        <tr><td></td><td><input type="submit" name="submit" value="simpan"></td></tr>
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

</script>