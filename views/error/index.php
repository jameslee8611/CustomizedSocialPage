<!--
    @Author : Seungchul Lee, Jae Yun Song
    @Date   : July 2, 2014
-->

<?php

if (!Session::get('loggedIn'))
{ ?>
    <div class="header-signup">
        <div class="row">
            <div class="large-1 columns">
                <div class="row">
                    <div class="large-2 columns">
                        <a href="<?php echo URL; ?>">Index</a>
                    </div>
                </div>
            </div>
            <div class="large-7 columns">
                <div class="row">
                    <form action ="<?php echo URL; ?>index/login" method="post">
                        <div class="large-4 columns">
                            <input type="text" name="login" placeholder="Login" />
                        </div>
                        <div class="large-4 columns">
                            <input type="password" name="password" placeholder="Password" />
                        </div>
                        <div class="large-4 columns">
                            <div class="row collapse">
                                <div class="small-9 columns">
                                    <input class="custom-tiny radius button" type="submit" value="Login"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="large-4 columns">
                        <input id="keep_loggedIn" type="checkbox"><label for="keep_loggedIn">Keep me logged in</label>
                    </div>
                    <div class="large-4 columns">
                        <a href="<?php echo URL; ?>forget">Forget PassWord?</a>
                    </div>
                    <div class="large-4 columns">

                    </div>
                </div>
            </div>
        </div>
    </div>
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