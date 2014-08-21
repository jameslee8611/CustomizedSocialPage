<!--
    @Author             : Seungchul Lee
    @Date               : June 24, 2014
    @Last Modification  : July 26, 2014
-->

<div class="content">

    <!-- Nav Side bar -->
    <div class="row">
        <div class="large-3 columns ">
            <div class="panel-media">
                <!-- Profile image -->
                <div id="profile-pic-container">
                    <a href="" class="profile-large-box"><img id="profile-pic" src="<?php echo URL.$this->profile_pic.'_large.jpg'; ?>"></a>
                    <?php if(Session::get('username') == $this->username) echo '<div id="change-profile-pic-background"></div><a class="change-profile-pic" data-reveal-id="myModal">Change Profile</a>'; ?>
                </div>
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

        <div class="large-6 columns">
            <!--<div class="controls">
                <button class="filter secondary round label" data-filter="all">All</button>
                <button class="filter secondary round label" data-filter=".category-1">Category 1</button>
                <button class="filter secondary round label" data-filter=".category-2">Category 2</button>
            </div>-->
            <a href="" data-dropdown="img-control" id="img-ctrl-button" data-options="align:right">All</a><br>
            <ui id="img-control" class="f-dropdown" data-dropdown-content>
                <li><a href="#" class="filter img-category" data-filter="all">All<i class="img-ctrl-check fi-check"></i></a></li>
                <li><a href="#" class="filter img-category" data-filter=".category-1">Category 1<i class="img-ctrl-check"></i></a></li>
                <li><a href="#" class="filter img-category" data-filter=".category-2">Category 2<i class="img-ctrl-check"></i></a></li>
            </ui>
            <div class="row">
                <div class="large-12 columns">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="row container" id="Container">
                                <?php
                                    if(isset($this->data) || !empty($this->data)){
                                        $image = $this->data;
                                        $length = count($image);
                                        for($i=0; $i<$length; $i++){
                                            echo"<div class='large-4 small-6 columns mix category-" . ($i+1) . "' data-myorder='" . ($i+1) . "'>
                                                    <img src='" . $image[$i] . "_large.jpg" . "'>
                                                    <div class='panel-media'>
                                                        <h5>Title</h5>
                                                        <h6 class='subheader'>subtitle</h6>
                                                    </div>
                                                </div>";
                                        }
                                    }
                                ?>
                                <div class="gap"></div>
                                <div class="gap"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <aside class="large-3 columns hide-for-small">
            <p><img src="http://placehold.it/300x440&text=[ad]"/></p>
            <p><img src="http://placehold.it/300x440&text=[ad]"/></p>
        </aside>
    </div>
</div>

<div id="myModal" class="reveal-modal" data-reveal>
    <h2>Change your profile picture.</h2>
    <form enctype="multipart/form-data">
        <input type="file" name="profile-pic-uploading" id="profile-pic-uploading" accept="image" hidden/>
        <div class="button tiny radius" id="profile-pic-select">Select Image</div>
        <div class="button tiny radius" id="profile-pic-upload">Upload Image</div>
    </form>

    <div id="crop-container"></div>
</div>