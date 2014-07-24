<!--
    @Author             : Seungchul Lee
    @Date               : July 2, 2014
    @Last Modification  : July 24, 2014
-->

<div class="content">

    <div class="row">
        
        <div class="large-9 push-3 columns">
            <h2 class="row">Privacy Settings</h2>
            <form action="" method="post">
                <label class="row">Post Privacy</label>
                <div id="post_privacy" class="row">
                    <label class="large-4 columns"><input type="radio" name="post_setting" value="post_public"/>Public</label>
                    <label class="large-4 columns"><input type="radio" name="post_setting" value="post_private"/>Private</label>
                    <label class="large-4 columns"><input type="radio" name="post_setting" value="post_friends"/>Friends</label>
                </div>
                <label class="row">Profile Privacy</label>
                <div id="profile_privacy" class="row">
                    <label class="large-4 columns"><input type="radio" name="profile_setting" value="profile_public"/>Public</label>
                    <label class="large-4 columns"><input type="radio" name="profile_setting" value="profile_private"/>Private</label>
                    <label class="large-4 columns"><input type="radio" name="profile_setting" value="profile_friends"/>Friends</label>
                </div>
                <div class="row">
                    <div class="large-12 column">
                        <input class="custom-tiny radius button post-button" type="submit" value="Submit"/>
                    </div>
                </div>
            </form>
        </div>

        <div class="large-3 pull-9 columns">
            <ul class="side-nav">
                <li><a href="<?php echo URL;?>setting/changePassword">Change password</a></li>
                <li><a href="<?php echo URL;?>setting/changePrivacy">Change privacy</a></li>
                <li><a href="<?php echo URL;?>setting/withdraw">Withdraw account</a></li>
            </ul>
        </div>

    </div>
</div>

<script>
    $(document).foundation();
</script>