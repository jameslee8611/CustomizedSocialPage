<!--
    @Author             : Seungchul Lee
    @Date               : June 27, 2014
    @Last Modification  : July 24, 2014
-->


<div class="conetnet-child">
    <div class="row">
        <div class="large-5 columns">
            Logo & Image would be here
        </div>
        <div class="large-4 columns">
            <h2>Sign up</h2>
            <div>
                <form action="signup" method="post" data-abide>
                    <div class="row">
                        <div class="large-12 column">
                            <label class="signup">User Name<input class="error" type="text" name="username" required pattern="alpha_numeric"/></label>
                            <small id="userid_error" class="error custom">Invalid Username!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 column">
                            <label class="signup">Email<input id="email" class="error" type="text" name="email" required pattern="email"/></label>
                            <small id="email_error" class="error custom" hidden>Enter a Valid Email!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 column">
                            <label class="signup">Confirm Email<input class="error" type="text" name="confirmemail" autocomplete="off" required data-equalto="email"/></label>
                            <small id="confirm_error" class="error custom" hidden>Email Does Not Match!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 column">
                            <label class="signup">Password<input class="error" type="password" name="password" required/></label>
                            <small id="password_error" class="error custom" hidden>Enter a Password!</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 column">
                            <label class="signup"><input id="signup" class="custom-tiny radius button" style="float: right" type="submit"/></label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="large-3 columns"></div>
    </div>
</div>
<script>
    var login_failed = "<?php echo (empty($this->login_failed) == false) ? $this->login_failed : false ?>";
    $(document).foundation();
    display_login_error(login_failed);
    function display_login_error(login_error) {
        if (login_error == true) {
            $("#login_error").show();
        }
        else {
            $("#login_error").hide();
        }
    }
</script>