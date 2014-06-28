<?php include_once 'forget_header.php' ?>
<div class="content">
    <h2>Forget Page</h2>
    <form action="<?php echo URL; ?>forget/askPassword" method="post">
	<label>Enter your username or email address associated with your account<br/></label><input type="text" name="email"/><br />
	<input class="small button" type="submit"/>
    </form>
</div>