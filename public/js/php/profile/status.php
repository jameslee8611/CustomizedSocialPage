<script language="javascript" type="text/javascript">
    /**
     * @author  Seungchul Lee
     * @date    July 24, 2014
     * @last modification   August 14, 2014
     */

    $('.change-profile-pic, #change-profile-pic-background').hide();

    $('#profile-pic-container').mouseenter(function(){
        $('.change-profile-pic, #change-profile-pic-background').show();
    }).mouseleave(function(){
        $('.change-profile-pic, #change-profile-pic-background').hide();
    });

    var delete_request;
    function delete_post(writer, id, type)
    {
        if (delete_request)
        {
            delete_request.abort();
        }

        request = $.ajax({
            url: <?php echo json_encode(URL . 'profile/delete_ajax/'); ?> + writer + '/' + id + '/' + type,
            type: 'post',
            success: function(html) {
                var data = html;
                if (data == <?php echo json_encode(SUCCESS); ?>) {
                    $("span[data-selector='tooltip-delete-box-" + id + "']").remove();
                    $('#post-' + id).fadeOut(500);
                    if(type == <?php echo json_encode(COMMENT); ?>)
                    {
                        var count = parseInt($('#comment-count').text())
                        count--
                        $('#comment-count').text(' ' + count.toString())
                    }
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

        $('<img id="waiting-wheel" src="<?php echo URL . "public/images/wheel.gif"; ?>" alt="Processing..">').hide().fadeIn('slow').insertAfter("#end-of-postbox");

        request = $.ajax({
            url: <?php echo json_encode(URL . 'profile/post_ajax/' . $this->username . '/' . STATUS); ?>,
            type: 'post',
            data: serializedData,
            success: function(jsonData) {
                $('#waiting-wheel').remove();
                var data = JSON.parse(jsonData);
                var url = <?php echo json_encode(URL); ?>;
                var content="";
                if (data.Type == <?php echo json_encode(STATUS)?>) content = '<div class="large-12 columns">' + data.Post + '</div>'
                else if (data.Type == <?php echo json_encode(IMAGE)?>) content = '<div class="large-12 columns"><img src="' + data.Post + '" alt="picture"></div>'
                $('<div class="mix" id="post-' + data.id + '"><div class="row">\
                        <div class="large-2 columns small-3">\
                            <img class="post-pic" src="' + data.profile_pic_medium + '"/>\
                        </div>\
                        <div class="large-10 columns">\
                            <div>\
                                <a href="' + url + data.Writer + '">\
                                    <strong>' + data.Writer + '</strong> &nbsp\
                                </a>\
                                <i id="tooltip-delete-box-' + data.id + '" class="' + data.Delete + ' right has-tip delete-box" data-tooltip title="delete" onclick="delete_post(\'' + data.Writer + '\',' + data.id + ',\'' + data.Type + '\')"></i>\n\
                                <p class="date">'
                                    + data.Date + ' &nbsp<i class="' + data.Privacy + '" data-dropdown="drop2-' + data.id + '" data-options="is_hover: true"></i>\
                                    <div class="f-dropdown content popover-box" id="drop2-' + data.id + '" data-dropdown-content>'
                                        + data.Privacy_description +
                                    '</div>\
                                </p>\
                            </div>\
                        </div>\
                        <div class="large-12 columns">\
                            <p class="post">\
                                <div class="row">'
                                + content +
                                '</div>\
                            </p>\
                            <div class="comment-head">\
                                <a href="#">comments </a>&nbsp&nbsp&nbsp&nbsp&nbsp\
                                <a href="#"><i class="fi-comment" id="comment-count"> 0</i></a>\
                            </div>\
                            <hr class="comment-hr"/>\
                            <div class="comment">\
                                <div class="row comment-box" id="' + data.id + '">\
                                    <div class="large-2 columns small">\
                                    <img class="comment-pic" src="' + data.profile_pic_small + '"/>\
                                </div>\
                                <form class="large-10 columns comment-type-area" id="post-comment-' + data.id + '" method="post">\
                                    <textarea onkeydown="if (event.keyCode == 13) $(\'#commnet-submit-' + data.id + '\').trigger(\'click\');" id="comment-post" name="comment-post" placeholder="Comment.."></textarea>\
                                    <input type="hidden" id="contentId" name="contentId" value="' + data.id + '" />\
                                    <input class="hide" type="submit" id="commnet-submit-' + data.id + '" value="post" onclick=postComment(' + data.id + ') />\
                                </form>\
                            </div>\
                        </div>\
                </div>').hide().fadeIn('slow').insertAfter("#end-of-postbox");

                $(document).foundation({
                    Dropdown: {
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
    
    /*
     * 
     * @param {type} param
     */
    var comment_request;
    
    var postComment = function(contentId) {
        $('#post-comment-' + contentId).submit(function(event) {
        if (comment_request)
        {
            comment_request.abort();
        }

        var $input = $(this).find("input, select, button, textarea, div");
        var serializedData = $(this).serialize();
        $input.prop("disabled", true);

        request = $.ajax({
            url: <?php echo json_encode(URL . 'profile/post_ajax/' . $this->username . '/' . COMMENT); ?>,
            type: 'post',
            data: serializedData,
            success: function(html) {
                var data = JSON.parse(html);
                console.log(data);
                var url = <?php echo json_encode(URL); ?>;
                $('<div class="row" id="post-' + data.CommentId + '">\
                        <div class="large-2 columns small-3"><img src="' + data.Profile_pic + '"/></div>\
                        <div class="large-10 columns">\
                            <i id="tooltip-delete-box-' + data.CommentId + '" class="' + data.Delete + ' right has-tip delete-box" data-tooltip title="delete" onclick="delete_post(\'' + data.Commentor + '\',' + data.CommentId + ',\'' + <?php echo json_encode(COMMENT); ?>+ '\')"></i>\
                            <p>\
                                <a href="' + <?php echo json_encode(URL); ?> + data.Commentor + '"><strong>' + data.Commentor + '</strong></a> &nbsp' + data.Comment + '\
                                <div class="date comment-date">' + data.Date + '</div>\
                            </p>\
                        </div>\
                    </div>').fadeIn('slow').insertBefore($("#" + contentId));
                
                var count = parseInt($('#comment-count').text())
                count++
                $('#comment-count').text(' ' + count.toString())
                                                        
                $(document).foundation({
                    Dropdown: {
                        is_hover: true
                    }
                });
            }
        });

        request.always(function() {
            $input.prop("disabled", false);
            $('#comment-post').val('');
        });

        event.preventDefault();
    });
    }
    

    

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

    // or directly on the modal
    $('a.change-profile-pic').click(function() {
        if($("#crop-container").children().length == 0)
        {
            $("#profile-pic-upload").css("display", "none");
        }
    });
    $('a.change-profile-pic').trigger('click');

    $("#profile-pic-select").click(function(){
        $("input[name='profile-pic-uploading']").click();
    });

    $("input[name='profile-pic-uploading']").on("change", function(evt){
        $("#profile-pic-upload").css("display", "initial");
        var files = evt.target.files[0];
        if(files != null){
            var reader = new FileReader();
            reader.onload = function(files){
                var crop_pic = document.createElement("img");
                crop_pic.setAttribute("id", "crop-pic");
                crop_pic.setAttribute("src", files.target.result);
                var container_width = crop_pic.width;
                var container_height = crop_pic.height;
                var crop_container = document.getElementById("crop-container");
                crop_container.setAttribute("width", container_width);
                crop_container.setAttribute("height", container_height);
                crop_container.appendChild(crop_pic);
                $("#crop-pic").cropper({aspectRatio: 1});
            }
            reader.readAsDataURL(files);
            $("#crop-container").empty();
        }
        else
        {
            $("#profile-pic-upload").css("display", "none");
        }
    });

    $("#profile-pic-upload").click(function(){
        if($("#crop-pic").length){
            var pic_info = $("#crop-pic").cropper("getData");
            var x_val = pic_info.x1;
            var y_val = pic_info.y1;
            var height = pic_info.height;
            var width = pic_info.width;

            var post_data = new FormData();
            
            post_data.append("file", document.getElementById("profile-pic-uploading").files[0]);
            post_data.append("x_val", x_val);
            post_data.append("y_val", y_val);
            post_data.append("height", height);
            post_data.append("width", width);

            $.ajax({
                type:"POST",
                url: <?php echo json_encode(URL . 'profile/picture_ajax/' . $this->username); ?>,
                data: post_data,
                processData: false,
                contentType: false,
                success: function(data){
                    $("#crop-container").empty();
                    var pic_paths = data.split(',');
                    set_image(pic_paths[0], pic_paths[1], pic_paths[2]);
                    $('#myModal').foundation('reveal', 'close');
                },
                error: function(){
                    alert("Failed!");
                }
            });
        }
        else{
            alert("No Image to Upload!");
        }
    });

    function set_image(large, medium, small){
        var profile = document.getElementById("profile-pic");
        profile.setAttribute("src", large);

        var post = document.getElementsByClassName("post-pic");
        for(i=0; i<post.length; i++)
        {
            post[i].setAttribute("src", medium);
        }

        var comment = document.getElementsByClassName("comment-pic");
        for(j=0; j<post.length; j++)
        {
            comment[j].setAttribute("src", small);
        }
    }
    
</script>