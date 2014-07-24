<!--
    @Author             : Seungchul Lee
    @Date               : June 24, 2014
    @Last Modification  : July 22, 2014
-->

<div class="content">

    <!-- Nav Side bar -->
    <div class="row">
        <div class="large-3 columns ">
            <div class="panel-media">
                <!-- Profile image -->
                <a href="#"><img id="profile-pic" src="http://placehold.it/300x240&text=[img]"></a>
                <h4><a href="<?php echo URL . $this->username; ?>"><?php echo $this->username; ?></a></h5>
                    <div class="section-container side-nav" data-section data-options="deep_linking: false; one_up: true">
                        <hr class="nav-divider">
                        <section class="section">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL; ?>setting">Setting</a></h6>
                        </section>
                        <hr class="nav-divider">
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL . $this->username; ?>">Wall</a></h6>
                        </section>
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL . $this->username . '/' . STATUS; ?>">Status</a></h6>
                        </section>
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL . $this->username . '/' . IMAGE; ?>">Pictures</a></h6>
                        </section>
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL . $this->username . '/' . VIDEO; ?>">Videos</a></h6>
                        </section>
                    </div>
            </div>
        </div>

        <div class="large-6 columns container" id="Container">
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
            </div><br id="end-of-postbox">
            <?php
            if (!isset($this->data) || empty($this->data)) {
       echo '<div class="row mix"></div>';
            } else {
                foreach ($this->data as $info) {
                    if (Session::get('username') == $this->username) {
                        $info['Delete'] = 'fi-trash';
                    }
       echo '<div class="mix" id="post-'. $info['id'] .'"><div class="row">
                <div class="large-2 columns small-3"><img src="http://placehold.it/80x80&text=[img]"/></div>
                <div class="large-10 columns">
                    <div>
                        <a href="' . URL . $info['Writer'] . '"><strong>' . $info['Writer'] . '</strong> &nbsp</a>
                        <i id="tooltip-delete-box-'. $info['id'] .'" class="'. $info['Delete'] .' right has-tip delete-box" data-tooltip title="delete" onclick="delete_post(\''. $info['Writer'] . '\',' . $info['id'] .')"></i>
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
                    echo '<a href="#comment-'. $info['id'] .'">comments</a>
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
           echo '   
                    <div class="row comment-box" id="comment-'. $info['id'] .'">
                        <div class="large-2 columns small">
                            <img src="http://placehold.it/40x40&text=[img]"/>
                        </div>
                        <div class="large-10 columns comment-type-area">
                            <textarea id="comment-textarea" placeholder="Comment.."></textarea>
                        </div>
                    </div>
                    </div>
                    
                </div>
            
            </div></div>';
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


<script language="javascript" type="text/javascript">
    /**
     * @author  Seungchul Lee
     * @date    July 24, 2014
     */

    var delete_request;
    function delete_post(writer, id)
    {
        if (delete_request)
        {
            delete_request.abort();
        }
        
        request = $.ajax({
            url: <?php echo json_encode(URL . 'profile/delete_ajax/'); ?> + writer + '/' + id,
            type: 'post',
            success: function(html) {
                var data = html;
                if (data == <?php echo json_encode(SUCCESS);?>) {
                    $("span[data-selector='tooltip-delete-box-" + id + "']").remove();
                    $('#post-' + id).fadeOut(500);
                }
                else {
                    alert("Sorry, we are having some network error.  Please try again later");
                }
            }
        });
    }
     
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
        
        $('<img id="waiting-wheel" src="<?php echo  URL . "public/images/wheel.gif"; ?>" alt="Processing..">').hide().fadeIn('slow').insertAfter( "#end-of-postbox" );
        
        request = $.ajax({
            url: <?php echo json_encode(URL . 'profile/post_ajax/' . $this->username); ?>,
            type: 'post',
            data: serializedData,
            success: function(html) {
                //$('#waiting-wheel').delay(3000).queue(function(){$(this).remove();});
                $('#waiting-wheel').remove();
                var data = JSON.parse(html);
                var url = <?php echo json_encode(URL);?>;
                $('<div class="mix" id="post-' + data.id + '"><div class="row">\n\
                        <div class="large-2 columns small-3">\n\
                            <img src="http://placehold.it/80x80&text=[img]"/>\n\
                        </div>\n\
                        <div class="large-10 columns">\n\
                            <div>\n\
                                <a href="' + url + data.Writer + '">\n\
                                    <strong>' + data.Writer + '</strong> &nbsp\n\
                                </a>\n\
                                <i id="tooltip-delete-box-' + data.id + '" class="' + data.Delete + ' right has-tip delete-box" data-tooltip title="delete" onclick="delete_post(\'' + data.Writer + '\',' + data.id + ')"></i>\n\
                                <p class="date">' 
                                    + data.Date + ' &nbsp\n\
                                    <i class="' + data.Privacy + '" data-dropdown="drop2-' + data.id + '" data-options="is_hover: true"></i>\n\
                                    <div class="f-dropdown content popover-box" id="drop2-' + data.id + '" data-dropdown-content>' 
                                        + data.Privacy_description + 
                                    '</div>\n\
                                </p>\n\
                                </div>\n\
                            </div>\n\
                            <div class="large-12 columns">\n\
                                <p class="post">' 
                                    + data.Post + '\
                                </p>\n\
                                <div class="comment-head">\n\
                                    <a href="#">comments </a>&nbsp&nbsp&nbsp&nbsp&nbsp\n\
                                    <a href="#"><i class="fi-comment"></i> 0</a>\n\
                                </div><hr class="comment-hr"/>\n\
                                <div class="comment">\n\
                                </div>\n\
                            </div>\n\
                        \n\
                        </div></div>\n\
                        ').hide().fadeIn('slow').insertAfter( "#end-of-postbox" );
                
                $(document).foundation({
                    Dropdown : {
                        is_hover: true
                    }
                });
            }
        });
        
        request.always(function() {
            $input.prop("disabled", false);
            $('#post-textarea').val('');
        });
        
        event.preventDefault();
    });
    
    $('.date').hover(function() {
        $(this).stop();
    });

    /**
     * Initial privacy drop-down menu setting
     */
    var privacyTracer = localStorage.getItem("privacyTracer");
    var privacyValueTracer = localStorage.getItem("privacyValueTracer");

    if (privacyTracer == null)
    {
        localStorage.setItem("privacyTracer", 'public-check');
        localStorage.setItem("privacyValueTracer", 'public_only');
        $(document).foundation();
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