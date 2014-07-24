<!--
    @Author             : Seungchul Lee
    @Date               : July 2, 2014
    @Last Modification  : July 24, 2014
-->  

<div class="content">

    <div class="row">    

        <div class="large-9 push-3 columns cancel-board">
            <h3>Are you sure that you'd like to cancel your account?</h3>
            <br><br>
            <a href="<?php echo URL; ?>setting/askWithdraw" onclick="return confirm('This is last call that I please you')" class="radius button alert">Drop</a>
            <a href="<?php echo URL; ?>" class="radius button">Back</a>
            <br><br><br>
        </div>

        <div class="large-3 pull-9 columns">

            <ul class="side-nav">
                <li><a href="<?php echo URL; ?>setting/changePassword">Change password</a></li>
                <li><a href="<?php echo URL;?>setting/changePrivacy">Change privacy</a></li>
                <li><a href="<?php echo URL;?>setting/withdraw">Withdraw account</a></li>
            </ul>

        </div>

    </div>

</div>