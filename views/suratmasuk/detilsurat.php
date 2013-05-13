<?php foreach($this->dataSurat as $value) { ?>
<div class="span6">
    <h2>INFORMASI SURAT :</h>
    <hr>
    </br>
    <div id="table-wrapper"><table class="CSSTableGenerator">
        <tr><td></td><td></td></tr>
        <tr><td>AGENDA</td><td><?php echo $this->data[1]; ?></td></tr>
        <tr><td>TANGGAL TERIMA</td><td><?php echo Tanggal::tgl_indo($this->data[2]); ?></td></tr>
        <!--<tr><td>TANGGAL SURAT</td><td><?php echo $this->data[3]; ?></td></tr>
        <tr><td>NOMOR SURAT</td><td><?php echo $this->data[4]; ?></td></tr>
        <tr><td>ASAL</td><td><?php echo $this->data[5]; ?></td></tr>
        <tr><td>PERIHAL</td><td><?php echo $this->data[6]; ?></td></tr>-->
        <tr><td></td><td>
                <?php if(Auth::isRole($role, 3)) { ?><a href="<?php echo URL;?>suratkeluar/rekam/<?php echo $this->data[0]; ?>" title="rekam tanggapan surat!" class="tip"><input class="btn" type="button" value="TANGGAPAN SURAT"></a>
                <a href="<?php echo URL;?>lampiran/rekam/<?php echo $this->data[0]; ?>/SM" title="rekam lampiran surat" class="tip"><input class="btn" type="button" value="REKAM LAMPIRAN"></a>
                <a href="<?php echo URL;?>arsip/rekam/<?php echo $this->data[0]; ?>/SM" title="rekam ke dalam arsip, pastikan fisik surat telah ditempatkan pada lokasi arsip!" class="tip"><input class="btn" type="button" value="ARSIP"></a><?php }?>
                <?php if(Auth::isRole($role, 2)) { ?><a href="<?php echo URL;?>suratmasuk/edit/<?php echo $this->data[0]; ?>" title="ubah data surat" class="tip"><input class="btn" type="button" value="U B A H"></a>
                <a href="<?php echo URL;?>suratmasuk/catatan/<?php echo $this->data[0]; ?>" title="rekam disposisi pejabat es IV kepada pelaksana" class="tip"><input class="btn" type="button" value="DISPOSISI KASI"></a><?php }?>
                <?php if(Auth::isRole($role, 1) OR Auth::isRole($role, 4)) echo '<a href="'.URL.'suratmasuk/disposisi/'.$this->data[0].'" title="rekam disposisi" class=tip><input class="btn" type=button value=disposisi></a>';?></td></tr>
                
    </table></div>
    
    <?php if($this->count>0){?>
    </br>
    <hr>
    <h3>Lampiran :</h3>
    <hr>
    </br>
    <div id="table-wrapper"><table class="CSSTableGenerator">
        <tr><th>TIPE</th><th>NOMOR</th><th>TANGGAL</th></tr>
        <?php
            
            foreach($this->lampiran as $value){
                echo "<tr><td>$value[tipe]</td><td ><a>$value[nomor] ; ".Tanggal::tgl_indo($value['tanggal'])."</a>
                </td>
                <td><button class=btn onclick=viewlampiran($value[id_lamp]);>view</button>
                <a href=".URL."lampiran/ubah/$value[id_lamp]><button class=btn >ubah</button></a>
                <a href=".URL."lampiran/hapus/><button class=btn onclick='return konfirmasi()'>hapus</button></a></td></tr>";
            }
        ?>
        
    </table></div>
    <?php } ?>
    </div>
<!-- menampilkan pdf hanya butuh iframe, cuman, browser harus embed ama pdf reader 
(install pdf reader setelah browser) -->
<div class="span7">
    
    <!--<p><h2>TAMPILAN ARSIP ELEKTRONIK</h2></p>-->
    <?php if($this->data[7]!='' AND file_exists('arsip/'.$this->data[7])) {?>
    <iframe src="<?php echo URL;?>arsip/<?php echo $this->data[7];?>">
    <?php }else{
        echo "</br></br></br></br></br><h2 align=center>File Surat Belum Ada</h2>";
    }
?>
  <p align="center">Mohon segera upload file surat yang bersangkutan</p>
</iframe></div>
<?php } ?>

<script type="text/javascript">
    
    function viewlampiran(id){
        w = window.open("<?php echo URL; ?>lampiran/view/"+id, "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=800,height=500");        
    }
    
    $(function(){
        $(".tip").tipTip({maxWidth: "auto", edgeOffset: 10});
    });
    
    function konfirmasi(){
        var answer = 'Anda yakin, data lampiran ini akan dihapus?'
        
        if(confirm(answer)){
            return true;
        }else{
            return false;
        }
    }
</script>

