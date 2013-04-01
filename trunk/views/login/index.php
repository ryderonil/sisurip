<div id="form-wrapper"><div ><form id="form-login" method="POST" action="<?php echo URL;?>login/auth">
    <label>Nama Pengguna</label><input class="required" id="" type="text" name="username" placeholder="username anda"></br>
    <label>Password</label><input class="required" id="" type="password" name="password"></br>
    <label></label><input type="submit" name="submit" value="LOGIN"></br>
    <?php if(isset($this->error['invalid'])) {?>
    <div id="error"><?php echo $this->error['invalid'];?></div> <?php }?>
</form></div></div>
