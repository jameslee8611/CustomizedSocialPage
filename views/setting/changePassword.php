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


        <h2>Change Password</h2>
            <div>
                <form action="setting/askChange" method="post" data-abide>
                    <div class="row">
                        <div class="large-6 column">
                            <label class="signup">Current Password<input class="error" type="password" name="old_password" required/></label>
                            <small id="password_error" class="error custom" hidden>Password is not correct!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-6 column">
                            <label class="signup">New Password<input id="newPassword" class="error" type="password" name="newPassword" required/></label>
                            <small id="password_error" class="error custom" hidden>New password needed!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-6 column">
                            <label class="signup">Confirm Password<input class="error" type="password" name="confirmPassword" required data-equalto="newPassword"/></label>
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
                <li><a href="<?php echo URL;?>setting/changePassword">Change Password</a></li>
                <li><a href="#">Change Privacy</a></li>
                <li><a href="#">DisJoin</a></li>
            </ul>

        </div>

    </div>


</div>

<script>
    $(document).foundation();
</script>