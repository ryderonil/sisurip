<?php 
if($this->file!='' AND file_exists('arsip/'.$this->file)) {?>
<div class="vlamp"><iframe  width= 800 height= 500 src="<?php echo URL;?>arsip/<?php echo $this->file;?>">
    <?php }else{
        echo "</br></br></br></br></br><h2 align=center>File Surat Belum Ada</h2>";
    } ?>
    
    <p align="center">Mohon segera upload file surat yang bersangkutan</p>
</iframe></div>