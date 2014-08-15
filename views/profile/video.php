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
                    <a href="" class="profile-large-box"><img id="profile-pic" src="<?php echo (file_exists(Session::get('profile_pic').'_large.jpg') ? URL.Session::get('profile_pic').'_large.jpg' : DEFAULT_PROFILE_PIC_LARGE); ?>"></a>
                    <div id="change-profile-pic-background"></div>
                    <a class="change-profile-pic" data-reveal-id="myModal">Change Profile</a>
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
            <div class="controls">
                <button class="filter secondary round label" data-filter="all">All</button>
                <button class="filter secondary round label" data-filter=".category-1">Category 1</button>
                <button class="filter secondary round label" data-filter=".category-2">Category 2</button>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="row container" id="Container">
                                <div class="large-4 small-6 columns mix category-1" data-myorder="1">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

                                <div class="large-4 small-6 columns mix category-1" data-myorder="2">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

                                <div class="large-4 small-6 columns mix category-1" data-myorder="3">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

                                <div class="large-4 small-6 columns mix category-2" data-myorder="4">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Titlee</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

                                <div class="large-4 small-6 columns mix category-1" data-myorder="5">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

                                <div class="large-4 small-6 columns mix category-1" data-myorder="6">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

                                <div class="large-4 small-6 columns mix category-2" data-myorder="7">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

                                <div class="large-4 small-6 columns mix category-2" data-myorder="8">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>
                                
                                <div class="large-4 small-6 columns mix category-2" data-myorder="8">
                                    <img src="http://placehold.it/500x500&text=Thumbnail">

                                    <div class="panel-media">
                                        <h5>Title</h5>
                                        <h6 class="subheader">subtitle</h6>
                                    </div>
                                </div>

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