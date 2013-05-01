<div id="form-wrapper">
    <div id="message"><?php echo isset($this->message)?$this->message:'';?></div>
    <div id="chart-wrapper">
        <p><strong>BACKUP</strong></p></br>
        <p><font>Halaman ini digunakan untuk melakukan backup database Sistem Informasi Penatausahaan Surat dan Arsip.
        Backup terdiri dari database mysql dan file zip arsip data komputer surat.</font></p>
        </br><p><form id="form-rekam" class="backup"><input type="button" value="BACKUP" onclick="backup();"></form>
    </div></br>
    <div id="chart-wrapper">
        <p><strong>RESTORE</strong></p></br>
        <p><font>Halaman ini digunakan untuk melakukan restore database.
            Silahkan pilih file backup dan tekan tombol restore.</font></p></br>
        <form id="form-rekam" class="backup" method="POST" action="<?php echo URL; ?>admin/restore" enctype="multipart/form-data">
            <p><input id="file" type="file" name="file" onchange="hidemessage();"></p>
        </br><p><input type="submit" value="RESTORE" name="submitRestoreDB" onclick="restores(document.getElementById('file').value);"></form>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
//        $('#message').fadeOut();
    })
    
    function backup(){
        $('#message').fadeOut();
        $.post("<?php echo URL;?>admin/backup",{},
            function(data){
                $('#message').fadeIn(500);
                $('#message').html(data);
            });
    }
    
    $("#form-rekam").submit(function(event){
       
           var myData = $( form ).serialize(); 
           $.ajax({
                type: "POST", 
                contentType:attr( "enctype", "multipart/form-data" ),
                url: "<?php echo URL;?>admin/restore",  
                data: myData,  
                success: function( data )  
                {
                     $('#message').fadeIn(500);
                    $('#message').html(data);
                }
           });
           return false;  
      
    });
    
    function hidemessage(){
        $('#message').fadeOut();
    }
    
    
    
</script>