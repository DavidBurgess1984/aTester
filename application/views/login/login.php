
<div id="login-form">
<form method='POST' action="<?php echo base_url('index.php/user/validateLogin');?>">

<h2>Login</h2>
<?php if( isset($error) && count($error) > 0) : ?>
<?php AppTesterError::displayHTML($error['title'], $error['message'])?>
<?php endif; ?>
<ul class='login-ul'>
<li><label>Email: </label><input size='40' type='text' name='email'/></li>
<li><label>Password: </label><input type='password' name='password'/></li>
<li><input type='submit' value='Login'/></li>
</ul>

</form>
</div>