<div class="header">
    <div class="row">
        <div class="large-4 columns small-8 left">
            <a href="<?php echo URL; ?>"><img src="http://placehold.it/40x40&text=[img]" /></a>
            <a href="<?php echo URL; ?>"><img src="http://placehold.it/160x40&text=[Logo]" /></a>
        </div>
        <div class="large-2 small-4 columns">
            <a href="<?php echo URL.Session::get('username'); ?>" class="has-tip" data-tooltip title="<?php echo Session::get('username'); ?>"><img src="http://placehold.it/40x40&text=[img]" /></a>
            <a href="<?php echo URL; ?>index/logout" class="has-tip" data-tooltip title="logout" ><img src="http://placehold.it/40x40&text=[img]" /></a>
        </div>
    </div>
</div>