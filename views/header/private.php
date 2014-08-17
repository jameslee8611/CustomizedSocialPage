<div class="header">
    <div class="row">
        <div class="large-4 columns small-8 left">
            <a href="<?php echo URL; ?>"><img src="http://placehold.it/40x40&text=[img]" /></a>
            <a href="<?php echo URL; ?>"><img src="http://placehold.it/160x40&text=[Logo]" /></a>
        </div>
        <div class="large-2 small-4 columns">
            <a href="<?php echo URL.Session::get('username'); ?>" class="has-tip" data-tooltip title="<?php echo Session::get('username'); ?>"><img id="header-profile-pic" src="<?php echo (file_exists(Session::get('profile_pic').'_xsmall.jpg') ? URL.Session::get('profile_pic').'_xsmall.jpg' : DEFAULT_PROFILE_PIC_XSMALL); ?>" /></a>
            <a href="<?php echo URL; ?>index/logout" class="has-tip" id="logout" data-tooltip title="logout" ><img src="<?php echo URL.'public/images/logout.png'; ?>" /></a>
        </div>
    </div>
</div>