<!doctype HTML>
<html>
    <head>
        <title>Customized Social</title>
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/default.css" />
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/test.js"></script>
    </head>
    <body>
        <div id="header">
            <a href="<?php echo URL; ?>index">Index</a>
            <?php if (Session::get('loggedIn') == true): ?>
                <a href="<?php echo URL; ?>index/logout">Logout</a>
            <?php else: ?>
                <a href="<?php echo URL; ?>about">About</a>
                <form action ="index/login" method="post">
                    <label>Login</label><input type="text" name="login"/>
                    <label>Password</label><input type="password" name="password"/>
                    <label></label><input type="submit" />
                </form>
                <a href="<?php echo URL; ?>forget">Forget PassWord</a>
            <?php endif; ?>
        </div>
        <div id="content">