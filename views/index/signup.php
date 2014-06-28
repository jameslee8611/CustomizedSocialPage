<!--
    @Author : Seungchul Lee, Jae Yun Song
    @Date   : June 27, 2014
-->
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
                                <input class="custom-tiny radius button" type="submit" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="small-4 columns">
                    <a href="<?php echo URL; ?>forget">Forget PassWord?</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="conetnet-child">
    <div class="row">
        <div class="large-5 columns">
            Logo & Image would be here
        </div>
        <div class="large-4 columns">
            <h2>Sign up</h2>
            <div>
                <form action="signup" method="post">
                    <div class="row">
                        <div class="large-12 column">
                            <label>User Name<input type="text" name="username" /></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 column">
                            <label>Email<input type="text" name="email"/></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 column">
                            <label>Confirm Email<input type="text" name="confirmemail"/></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 column">
                            <label>Password<input type="password" name="password" /></label>
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
        <div class="large-3 columns">

        </div>
    </div>
</div>