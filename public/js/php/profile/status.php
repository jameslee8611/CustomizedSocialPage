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
                $('<div class="row mix" id="post-' + data.id + '">\n\
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
                        </div>\n\
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