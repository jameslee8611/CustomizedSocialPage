<!--
    @Author             : Seungchul Lee
    @Date               : June 24, 2014
    @Last Modification  : July 22, 2014
-->

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
        <div class="large-3 columns ">
            <div class="panel">
                <a href="#"><img src="http://placehold.it/300x240&text=[img]"/></a>
                <h4><a href="<?php echo URL . $this->username; ?>"><?php echo $this->username; ?></a></h5>
                    <div class="section-container side-nav" data-section data-options="deep_linking: false; one_up: true">
                        <section class="section">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL; ?>setting">Setting</a></h6>
                        </section>
                        <section class="divider">

                        </section>
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL . Session::get('username') . '/' . STATUS; ?>">Status</a></h6>
                        </section>
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="#">Pictures</a></h6>
                        </section>
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="#">Videos</a></h6>
                        </section>
                    </div>

            </div>
        </div>

        <div class="large-6 columns">
            <div class="row" id="post-box">
                <div class="large-12 columns">
                    <form id="post-data" method="post" class="post-form">
                        <ul class="tabs" data-tab>
                            <li class="tab-title"><a class="post-icon" href="#image"><i class="fi-photo"></i></a></li>
                            <li class="tab-title"><a class="post-icon" href="#video"><i class="fi-video"></i></a></li>
                        </ul>
                        <div class="tabs-content custom">
                            <div class="content custom" id="image">Image<i class="fi-x"></i></div>
                            <div class="content custom" id="video">Video<i class="fi-x"></i></div>
                        </div>
                        <div class="post-container">
                            <textarea id="post-textarea" name="post-text" rows="3" placeholder="Type Content to Post"></textarea>
                            <div id="post-friends" class="row custom" hidden>
                                <div class="large-6 columns custom" name="privacy-range">
                                    <a href="#" id="privacy-range-dropdown" data-options="align:right" data-dropdown="privacy-range" class="custom-tiny radius button">Privacy &raquo;</a>
                                    <ul id="privacy-range" class="f-dropdown" data-dropdown-content>
                                        <li><a class="privacy-menu" id="privacy-range-public" href="#"> <i class="fi-rss"></i>&nbsp; Public<i class="default" id="public-check"></i></a></li>
                                        <li><a class="privacy-menu" id="privacy-range-friend" href="#"> <i class="fi-torsos-all"></i>&nbsp;Friends<i class="default" id="friend-check"></i></a></li>
                                        <li><a class="privacy-menu" id="privacy-range-personal" href="#"> <i class="fi-lock"></i>&nbsp; Personal<i class="default" id="personal-check"></i></a></li>
                                    </ul>
                                    <input type="hidden" id="privacy-menu-setting" name="privacy" value=""/>
                                </div>
                                <div class="large-6 columns custom">
                                    <input class="custom-tiny radius button post-button" id="post-submit" type="submit" value="Post"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><br>
            <?php
            if (!isset($this->data) || empty($this->data)) {
       echo '<div class="row"></div>';
            } else {
                foreach ($this->data as $info) {
       echo '<div class="row" id="post-'. $info['id'] .'">
                <div class="large-2 columns small-3"><img src="http://placehold.it/80x80&text=[img]"/></div>
                <div class="large-10 columns">
                    <div>';
                    echo '<a href="' . URL . $info['Writer'] . '"><strong>' . $info['Writer'] . '</strong> &nbsp</a>';
                    echo '
                        <p class="date">
                            ' . $info['Date'] . ' &nbsp<i class="' . $info['Privacy'] . '" data-dropdown="drop2-' . $info['id'] . '" data-options="is_hover: true"></i>
                            <div class="f-dropdown content popover-box" id="drop2-' . $info['id'] . '" data-dropdown-content>
                                ' . $info['Privacy_description'] . '
                            </div>
                        </p>
                    </div>
                </div>
                <div class="large-12 columns">
                    <p class="post">
                        ' . $info['Post'] . '
                    </p>
                    <div class="comment-head">';
                    echo '<a href="#">comments</a>
                        &nbsp&nbsp&nbsp&nbsp&nbsp
                        <a href="#"><i class="fi-comment"></i> ' . count($info['Comments']) . '</a>
                    </div>
                    <hr class="comment-hr"/>
                    <div class="comment">';
                    foreach ($info['Comments'] as $comment) {
                   echo '<div class="row">
                            <div class="large-2 columns small-3"><img src="http://placehold.it/50x50&text=[img]"/></div>
                            <div class="large-10 columns">
                                <p>';
                               echo '<strong>' . $comment['Writer'] . ':</strong> &nbsp' . $comment['Comment'];
                          echo '</p>
                            </div>
                        </div>';
                    }
           echo '   </div>
                </div>
            </div>
            <hr/>';
                }
            }
            ?>
        </div>
        <aside class="large-3 columns hide-for-small">
            <p><img src="http://placehold.it/300x440&text=[ad]"/></p>
            <p><img src="http://placehold.it/300x440&text=[ad]"/></p>
        </aside>
    </div>
</div>


<script>
    /**
     * @author  Seungchul Lee
     * @date    July 22, 2014
     */


    /**
     * Post submit handler
     */
    var request;
    
    $('#post-data').submit(function(event) {
        if (request)
        {
            request.abort();
        }
        
        var $input = $(this).find("input, select, button, textarea, div");
        var serializedData = $(this).serialize();
        $input.prop("disabled", true);
        
        request = $.ajax({
            url: <?php echo json_encode(URL . 'profile/post_ajax/' . $this->username); ?>,
            type: 'post',
            data: serializedData,
            success: function(html) {
                var data = JSON.parse(html);
                $('<div class="row" id="post-' + data.id + '"></div>').hide().fadeIn('slow').insertAfter( "#post-box" );
                $('#post-' + data.id).html('<br><div class="large-2 columns small-3"><img src="http://placehold.it/80x80&text=[img]"/></div><div class="large-10 columns"><div><a href="' + data.Writer + '"><strong>' + data.Writer + '</strong> &nbsp</a><p class="date">' + data.Date + '&nbsp<i class="data.Privacy" data-dropdown="drop2-' + data.id + '" data-options="is_hover: true"></i><div class="f-dropdown content popover-box" id="drop2-' + data.id + '" data-dropdown-content>' + data.Privacy_description + '</div></p></div></div><div class="large-12 columns"><p class="post">' + data.Post + '</p><div class="comment-head"><a href="#">comments</a>&nbsp&nbsp&nbsp&nbsp&nbsp<a href="#"><i class="fi-comment"></i> 0</a></div><hr class="comment-hr"/><div class="comment"></div></div><hr/>');
            }
        });
        
        request.always(function() {
            $input.prop("disabled", false);
            $('#post-textarea').val('');
        });
        
        event.preventDefault();
    });

    /**
     * Initial privacy drop-down menu setting
     */
    var privacyTracer = localStorage.getItem("privacyTracer");
    var privacyValueTracer = localStorage.getItem("privacyValueTracer");

    if (privacyTracer === null)
    {
        localStorage.setItem("privacyTracer", 'public-check');
        localStorage.setItem("privacyValueTracer", 'public_only');
    }

    document.getElementById(privacyTracer.toString()).className = 'fi-check right';
    document.getElementById('privacy-menu-setting').value = privacyValueTracer;

    /**
     * privacy setting drop-down menu button's handler
     */
    $('.privacy-menu').click(function() {
        //select Id
        document.getElementById('privacy-range-dropdown').className = 'custom-tiny radius button';
        document.getElementById('privacy-range').className = 'f-dropdown';
        document.getElementById('privacy-range').style.left = "-99999px";

        switch ($(this).attr('id'))
        {
            case 'privacy-range-public':
                localStorage.setItem("privacyTracer", 'public-check');
                document.getElementById('public-check').className = 'fi-check right';
                document.getElementById('friend-check').className = 'default';
                document.getElementById('personal-check').className = 'default';
                document.getElementById('privacy-menu-setting').value = 0;
                localStorage.setItem("privacyValueTracer", 0);
                break;
            case 'privacy-range-friend':
                localStorage.setItem("privacyTracer", 'friend-check');
                document.getElementById('public-check').className = 'default';
                document.getElementById('friend-check').className = 'fi-check right';
                document.getElementById('personal-check').className = 'default';
                document.getElementById('privacy-menu-setting').value = 1;
                localStorage.setItem("privacyValueTracer", 1);
                break;
            case 'privacy-range-personal':
                localStorage.setItem("privacyTracer", 'personal-check');
                document.getElementById('public-check').className = 'default';
                document.getElementById('friend-check').className = 'default';
                document.getElementById('personal-check').className = 'fi-check right';
                document.getElementById('privacy-menu-setting').value = 2;
                localStorage.setItem("privacyValueTracer", 2);
                break;
        }
    });

    $(document).foundation();
    $('.tab-title').click(function() {
        if ($(this).hasClass('active')) {
            var deact_target = $(this).children().attr('href')
            $(this).removeClass('active');
            $(deact_target).removeClass('active');
            return false;
        }
    });
    $('#post-textarea').click(function() {
        $('#post-friends').show();
    });
</script>
