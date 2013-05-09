<div class="form-login">
    <h2>LOGIN</h2>
<hr>
</br>
<div ><form id="form-login" method="POST" action="<?php echo URL;?>login/auth">
    <label>Nama Pengguna</label><input class="required" id="" type="text" name="username" placeholder="username anda" onkeyup="hidewarning();"></br>
    <label>Password</label><input class="required" id="" type="password" name="password" onkeyup="hidewarning();"></br>
    <label></label><input type="submit" name="submit" value="LOGIN"></br>
    <?php if(isset($this->error['invalid'])) {?>
    <div id="error"><?php echo $this->error['invalid'];?></div> <?php }?>
</form></div></div>

<script type="text/javascript">

    function hidewarning(){
        $('#error').fadeOut(0);
    }

</script>
