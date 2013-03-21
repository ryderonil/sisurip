<?php foreach($this->dataSurat as $key=>$value) { ?>
<div class="left">
    <table class="CSSTableGenerator">
        <tr><td></td><td></td></tr>
        <tr><td>AGENDA</td><td><?php echo $this->data[1]; ?></td></tr>
        <tr><td>TANGGAL TERIMA</td><td><?php echo Tanggal::tgl_indo($this->data[2]); ?></td></tr>
        <!--<tr><td>TANGGAL SURAT</td><td><?php echo $this->data[3]; ?></td></tr>
        <tr><td>NOMOR SURAT</td><td><?php echo $this->data[4]; ?></td></tr>
        <tr><td>ASAL</td><td><?php echo $this->data[5]; ?></td></tr>
        <tr><td>PERIHAL</td><td><?php echo $this->data[6]; ?></td></tr>-->
        <tr><td></td><td>
                <a href="<?php echo URL;?>suratkeluar/rekam/<?php echo $this->data[0]; ?>"><input class="btn" type="button" value="TANGGAPAN SURAT"></a>
                <a href="<?php echo URL;?>lampiran/rekam/<?php echo $this->data[0]; ?>"><input class="btn" type="button" value="REKAM LAMPIRAN"></a>
                <a href="<?php echo URL;?>arsip/rekam/<?php echo $this->data[0]; ?>"><input class="btn" type="button" value="ARSIP"></a>
                <a href="<?php echo URL;?>suratmasuk/edit/<?php echo $this->data[0]; ?>"><input class="btn" type="button" value="U B A H"></a>
                <a href="<?php echo URL;?>suratmasuk/catatan/<?php echo $this->data[0]; ?>"><input class="btn" type="button" value="DISPOSISI KASI"></a></td></tr>
    </table>
    </div>
<!-- menampilkan pdf hanya butuh iframe, cuman, browser harus embed ama pdf reader 
(install pdf reader setelah browser) -->
<div class="right">
    
    <!--<p><h2>TAMPILAN ARSIP ELEKTRONIK</h2></p>-->    
    <iframe src="<?php echo URL;?>arsip/1.pdf">
  <p>browser anda tidak mendukung tampilan ini.</p>
</iframe></div>
<?php } ?>

