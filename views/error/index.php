<!--
    @Author : Seungchul Lee, Jae Yun Song
    @Date   : July 2, 2014
    @Last Modification  : July 24, 2014
-->

<?php
if (!Session::get('loggedIn'))
{ ?>
    <div class="conetnet-child">
        <div class="row">
            <div class="large-5 columns">
                Page does not exist or Your request is not proper
            </div>
        </div>
    </div>
<?php
}
else
{ ?>
    <div class="content">
        <div class="row">
            <div class="large-5 columns">
                Page does not exist or Your request is not proper
            </div>
        </div>
    </div>
<?php
}

?>

<script>
    $(document).foundation();
</script>