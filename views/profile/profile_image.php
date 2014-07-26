<!--
    @Author             : Seungchul Lee
    @Date               : June 24, 2014
    @Last Modification  : July 22, 2014
-->

<div class="content">

    <!-- Nav Side bar -->
    <div class="row">
        <div class="large-3 columns">
            <div class="panel-media">
                <!-- Profile image -->
                <a href="<?php echo URL . $this->username . '/' . PIC; ?>"><img id="profile-img" src="http://placehold.it/300x240&text=[img]"></a>
                <h4><a href="<?php echo URL . $this->username; ?>"><?php echo $this->username; ?></a></h4>
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

        <div class="large-3 columns">
            <form enctype="multipart/form-data">
                <input type="file" name="profile-pic" id="profile-pic" accept="image" hidden/>
                <button type="button" id="profile-pic-select">Select Image</button>
            </form>

            <div id="crop-container"></div>

            <button type="button" id="profile-pic-upload">Upload Image</button>

        </div>

        <aside class="large-3 columns hide-for-small">
            <p><img src="http://placehold.it/300x440&text=[ad]"/></p>
            <p><img src="http://placehold.it/300x440&text=[ad]"/></p>
        </aside>

    </div>

</div>

<script>
    $("#profile-pic-select").click(function(){
        $("input[name='profile-pic']").click();
    });

    $("input[name='profile-pic']").on("change", function(evt){
        $("#crop-container").empty();
        var files = evt.target.files[0];
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
    });

    $("#profile-pic-upload").click(function(){
        if($("#crop-pic").length){
            var pic_info = $("#crop-pic").cropper("getData");
            var x_val = pic_info.x1;
            var y_val = pic_info.y1;
            var height = pic_info.height;
            var width = pic_info.width;

            var post_data = new FormData();
            post_data.append("file", $("input")[0].files[0]);
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
                    set_image(data);
                    alert(data);
                    alert("Success!");
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

    function set_image(image_path){
        var img = document.getElementById("profile-img");
        img.setAttribute("src", image_path);
    }

</script>