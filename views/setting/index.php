<!--
    @author Seungchul
    @date July 2, 2014
-->

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

            <h3>Setting page <small>!Private page</small></h3>

            <p>You can change your privacy or change your password</p>

        </div>


        <!-- Side bar menu -->
        <div class="large-3 pull-9 columns">

            <ul class="side-nav">
                <li><a href="<?php echo URL;?>setting/changePassword">Change password</a></li>
                <li><a href="<?php echo URL;?>setting/changePrivacy">Change Privacy</a></li>
                <li><a href="<?php echo URL;?>setting/withdraw">Withdraw account</a></li>
            </ul>

        </div>

    </div>


</div>

<script>
    $(document).foundation();
</script>