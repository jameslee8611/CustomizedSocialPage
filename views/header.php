<!doctype HTML>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Customized Social</title>
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/default.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/foundation.css" />
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/test.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/vendor/modernizr.js"></script>
    </head>
    <body>
        <div class="header">
            <div class="row">
                <div class="large-1 columns">
                    <div class="row">
                        <div class="large-2 columns">
                            <a href="<?php echo URL; ?>">Index</a>
                        </div>
                        <?php if (Session::get('loggedIn') == true): ?>
                        <div class="large-2 columns">
                            <a href="<?php echo URL; ?>index/logout">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
                        <?php else: ?>
                        <div class="large-2 columns">
                            <a href="<?php echo URL; ?>about">About</a>
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
                                        <input class="small button" type="submit" />
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
            <?php endif; ?>
        </div>