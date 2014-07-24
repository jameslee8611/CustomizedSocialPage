<!--
    @Author             : Seungchul Lee
    @Date               : June 27, 2014
    @Last Modification  : July 24, 2014
-->


<div class="conetnet-child">
    <div class="row">
        <h3>Your request has successively treated</h3>
        <h4>Please reset your password with given code in your email</h4>
    </div>

    <div class="row">
        <div>
            <form action="<?php echo URL; ?>forget/resetPassword" method="post">
                <div class="row">
                    <div class="large-12 column">
                        <label>Reset Code<input type="text" name="reset" /></label>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 column">
                        <label>New Password<input type="password" name="new_password"/></label>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 column">
                        <label>Confirm Password<input type="password" name="confirm_password"/></label>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 column">
                        <label><input class="custom-tiny radius button " type="submit" /></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>