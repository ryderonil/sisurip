<div class="divleft"><div id="form-wrapper"><h1>BACKUP & RESTORE DATA</h1>
    <div id="message"><?php echo isset($this->message)?$this->message:'';?></div>
    <div class="preload">
        <img src="<?php echo URL; ?>public/images/loading.gif">
    </div>
    <div id="chart-wrapper">
        <p><strong>BACKUP</strong></p></br>
        <p><font>Halaman ini digunakan untuk melakukan backup database Sistem Informasi Penatausahaan Surat dan Arsip.
        Backup terdiri dari database mysql dan file zip arsip data komputer surat.</font></p>
        </br><p><form id="form-rekam" class="backup"><input class="btn backup" type="button" value="BACKUP" onclick="backup();"></form>
    </div></br>
    <div id="chart-wrapper">
        <p><strong>RESTORE</strong></p></br>
        <p><font>Halaman ini digunakan untuk melakukan restore database.
            Silahkan pilih file backup dan tekan tombol restore.</font></p></br>
        <form id="form-rekam" class="backup" method="POST" action="<?php echo URL; ?>admin/restore" enctype="multipart/form-data">
            <p><input id="file" type="file" name="file" onchange="hidemessage();"></p>
        </br><p><input class="btn restore"type="submit" value="RESTORE" name="submitRestoreDB" onclick="preload();"></form>
    </div>
</div></div>

<script type="text/javascript">
   
    function backup(){
        $('#message').fadeOut();
        $('.preload').fadeIn(500);
        $.post("<?php echo URL;?>admin/backup",{},
            function(data){
                $('.preload').fadeOut(500);
                $('#message').fadeIn(500);
                $('#message').html(data);
            });
    }   
    
    function preload(){
        $('.preload').fadeIn(500);
    }
    
    function hidemessage(){
        $('#message').fadeOut();
    }
    
    
    
</script>