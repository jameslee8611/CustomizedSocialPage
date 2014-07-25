<div class="header-signup">
    <div class="row">
        <div class="large-4 small-4 columns">
            <br/>
            <a href="<?php echo URL; ?>"><img src="http://placehold.it/160x40&text=[Logo]" /></a>
        </div>
        <div class="large-7 small-8 columns">
            <div class="row">
                <form action ="<?php echo URL; ?>index/login" method="post">
                    <div class="large-4 small-4 columns">
                        <input type="text" name="login" placeholder="Login" />
                    </div>
                    <div class="large-4 small-4 columns">
                        <input type="password" name="password" placeholder="Password" />
                    </div>
                    <div class="large-4 small-4 columns">
                        <div class="row collapse">
                            <div class="small-9 columns">
                                <input class="custom-tiny radius button" type="submit" value="Login"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="large-4 small-4 columns">
                    <input id="keep_loggedIn" type="checkbox"><label for="keep_loggedIn">Keep me logged in</label>
                </div>
                <div class="large-8 small-8 columns">
                    <a href="<?php echo URL; ?>forget">Forget PassWord?</a>
                </div>
            </div>
        </div>
    </div>
</div>