<?php 
/**
 * @author Seungchul Lee
 * @Date   : June 27, 2014
 */

include_once 'forget_header.php' 
?>
<div class="content">
    <h3>Your request has successively treated</h3>
    <h4>Please reset your password with given code in your email</h4>

    <form action="<?php echo URL; ?>forget/resetPassword" method="POST">
        <label>Reset Code</label><input type="text" name="reset" /><br />
        <label>New Password</label><input type="password" name="new_password" /><br />
        <label>Confirm Password</label><input type="password" name="confirm_password" /><br />
        <label></label><input type="submit" />
    </form>
</div>