<script language="javascript" type="text/javascript">
    /**
     * @author  Seungchul Lee, Jae Yun Song
     * @date    July 24, 2014
     * @last modification   Ausgust 14, 2014
     */

    $(".img-category").click(function(){
        var text = $(this).html();
        $("#img-ctrl-button").html(text);
        $("#img-control").removeClass("open");
        $("#img-control").css("left", "-99999px");
    });

    $('.change-profile-pic, #change-profile-pic-background').hide();

    $('#profile-pic-container').mouseenter(function(){
        $('.change-profile-pic, #change-profile-pic-background').show();
    }).mouseleave(function(){
        $('.change-profile-pic, #change-profile-pic-background').hide();
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
            $("#crop-container").empty();
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
                    set_image(pic_paths[0], pic_paths[1], pic_paths[2], pic_paths[3]);
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

    function set_image(large, medium, small, xsmall){
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
        
        var profile_header = document.getElementById("header-profile-pic");
        profile_header.setAttribute("src", xsmall);
    }
    
</script>