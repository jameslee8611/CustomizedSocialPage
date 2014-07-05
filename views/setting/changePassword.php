<div class="header">
    <div class="row">
        <div class="large-1 columns">
            <div class="row">
                <div class="large-2 columns">
                    <a href="<?php echo URL; ?>">Index</a>
                </div>
                <div class="large-2 columns">
                    <a href="<?php echo URL; ?>index/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>   

<div class="content">

    <div class="row">    

        <div class="large-9 push-3 columns">
            <h2>Change Password</h2>
            <form action="askChange" method="post" data-abide>
                <div class="row">
                    <div class="large-6 column" id="current-password-field">
                        <label class="signup">Current Password<input class="error" type="password" id="old_password" name="old_password" required/></label>
                        <small id="password_error" class="error custom" hidden>Password is not correct!</small>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 column">
                        <label class="signup">New Password<input class="error" type="password" id="new_password" name="new_password" required/></label>
                        <small id="password_error" class="error custom" hidden>New password needed!</small>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 column">
                        <label class="signup">Confirm Password<input class="error" type="password" name="confirm_password" required data-equalto="new_password"/></label>
                        <small id="confirm_error" class="error custom" hidden>Password Does Not Match!</small>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 column">
                        <label class="signup"><input id="signup" class="custom-tiny radius button" style="float: right" type="submit"/></label>
                    </div>
                </div>
            </form>
        </div>




        <div class="large-3 pull-9 columns">

            <ul class="side-nav">
                <li><a href="<?php echo URL; ?>setting/changePassword">Change password</a></li>
                <li><a href="#">Change privacy</a></li>
                <li><a href="<?php echo URL;?>setting/withdraw">Withdraw account</a></li>
            </ul>

        </div>

    </div>


</div>

<script type="text/javascript">
    $(document).foundation();
    
    var error_msg_trigger = "<?php echo (empty($this->error_msg_trigger) == false) ? $this->error_msg_trigger : false; ?>"
    $(document).ready(changeClassName("current-password-field", "large-6 column", "error"));
    
    function changeClassName(id, newName, error)
    {
        if (error_msg_trigger)
        {
            document.getElementById(id).className = newName + " " + error;
        }
    }
</script>