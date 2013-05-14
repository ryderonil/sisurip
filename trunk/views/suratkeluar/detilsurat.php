
<div class="left">
    <h2>INFORMASI SURAT :</h>
    <hr>
    </br>
    <div id="table-wrapper"><table class="CSSTableGenerator">
        <tr><td></td><td></td></tr>
        <?php if($this->rujukan != 0 AND $this->rujukan !=''){?>
        <tr><td>NOMOR SURAT MASUK</td><td><?php echo $this->rujukan; ?></td></tr>
        <?php } ?>
        <tr><td>TANGGAL/NO SURAT</td><td><?php echo Tanggal::tgl_indo($this->tgl_surat).'/'.$this->no_surat; ?></td></tr>
        <?php if($this->no_surat != 0 AND $this->no_surat !=''){?>
        <tr><td>NOMOR SURAT</td><td><?php echo $this->no_surat; ?></td></tr>
        <?php } ?>
        <tr><td>TIPE NASKAH DINAS</td><td><?php echo $this->tipe; ?></td></tr>
        <tr><td>TUJUAN</td><td><?php echo $this->tujuan; ?></td></tr>
        <tr><td>PERIHAL</td><td><?php echo $this->perihal; ?></td></tr>
        <tr><td>SIFAT/JENIS/STATUS</td><td><?php echo $this->sifat.'/'.$this->jenis.'-'.$this->status; ?></td></tr>
        <!--<tr><td>JENIS</td><td><?php echo $this->jenis; ?></td></tr>        
        <tr><td>STATUS</td><td><?php echo $this->status; ?></td></tr>-->        
        <tr><td></td><td>                
                <?php if(Auth::isRole($role, 3)) { ?><a href="<?php echo URL;?>lampiran/rekam/<?php echo $this->id; ?>/SK" title="rekam lampiran surat" class="tip"><input class="btn" type="button" value="REKAM LAMPIRAN"></a>
                <a href="<?php echo URL;?>arsip/rekam/<?php echo $this->id; ?>/SK" title="rekam ke dalam lokasi arsip" class="tip"><input class="btn" type="button" value="ARSIP"></a>
                <a href="<?php echo URL;?>suratkeluar/edit/<?php echo $this->id; ?>" title="ubah data surat keluar" class="tip"><input class="btn" type="button" value="U B A H"></a><?php } ?>
                <?php if(Auth::isRole($role, 2) OR Auth::isRole($role, 1)) { ?><a href="<?php echo URL;?>suratkeluar/rekamrev/<?php echo $this->id; ?>" title="rekam dan upload revisi konsep surat" class="tip"><input class="btn" type="button" value="REKAM REVISI"></a><?php } ?></td></tr>
    </table></div>
    
    <?php if($this->count>0){?>
    </br>
    <hr>
    <h3>Lampiran :</h3>
    <hr>
    </br>
    <table class="CSSTableGenerator">
        <tr><th>TIPE</th><th>NOMOR</th><th>TANGGAL</th></tr>
        <?php
            
            foreach($this->datal as $value){
                echo "<tr><td>$value[tipe]</td><td>$value[nomor] ; ".Tanggal::tgl_indo($value['tanggal'])."</td>
                    <td><button class=btn onclick=viewlampiran($value[id_lamp]);>view</button>
                    <a href=".URL."lampiran/ubah/$value[id_lamp]><button class=btn >ubah</button></a>
                    <a href=".URL."lampiran/hapus/><button class=btn onclick='return konfirmasi()'>hapus</button></a></td></tr>";
            }
        ?>
        
    </table>
    <?php } ?>
    </div>
<!-- menampilkan pdf hanya butuh iframe, cuman, browser harus embed ama pdf reader 
(install pdf reader setelah browser) -->
<div class="right">
    
    <!--<p><h2>TAMPILAN ARSIP ELEKTRONIK</h2></p>-->
    <?php if($this->file!='' AND file_exists('arsip/'.$this->file)) {?>
    <iframe src="<?php echo URL;?>arsip/<?php echo $this->file;?>">
    <?php }else{
        echo "</br></br></br></br></br><h2 align=center>File Surat Belum Ada</h2>";
    }
?>
  <p align="center">Mohon segera upload file surat yang bersangkutan</p>
</iframe></div>

<script type="text/javascript">
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

function viewlampiran(id){
        w = window.open("<?php echo URL; ?>lampiran/view/"+id, "Cetak Disposisi","toolbar=0,menubar=0,location=0,status=0,width=800,height=500");        
    }
</script>
