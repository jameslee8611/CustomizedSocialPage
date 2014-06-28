<?php
/**
 * @author Seungchul Lee, Jae Yun Song
 * @Date   : June 27, 2014
 */
include_once 'forget_header.php'
?>
<div class="conetnet-child">
    <div class="row">
        <h2 class="large-12 columns">Forget Page</h2>
    </div>
    <div class="row">		
        <div class="large-7 columns">
            <form action="<?php echo URL; ?>forget/askPassword" method="post">
                <label>Enter your username or email address associated with your account<br/></label><input type="text" name="email"/><br />
                <input class="custom-tiny radius button" type="submit"/>
            </form>
        </div>
        <div class="large-5 columns"></div>
    </div>
</div>