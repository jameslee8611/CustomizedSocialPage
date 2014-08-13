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
                <div id="profile-pic-container">
                    <a href="" class="profile-large-box"><img id="profile-pic" src="<?php echo $this->profile_pic; ?>"></a>
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
            if (isset($this->data) || !empty($this->data)) {
                foreach ($this->data as $info) {
                    if (Session::get('username') == $this->username) {
                        $info['Delete'] = 'fi-trash';
                    }
                    echo '<div class="mix" id="post-' . $info['id'] . '"><div class="row">
                <div class="large-2 columns small-3"><img class="post-pic" src="'. $info['profile_pic_medium'] .'"/></div>
                <div class="large-10 columns">
                    <div>
                        <a href="' . URL . $info['Writer'] . '"><strong>' . $info['Writer'] . '</strong> &nbsp</a>
                        <i id="tooltip-delete-box-' . $info['id'] . '" class="' . $info['Delete'] . ' right has-tip delete-box" data-tooltip title="delete" onclick="delete_post(\'' . $info['Writer'] . '\',' . $info['id'] . ',\'' . $info['Type'] . '\')"></i>
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
                    echo '<a href="#comment-' . $info['id'] . '">comments</a>
                        &nbsp&nbsp&nbsp&nbsp&nbsp
                        <a href="#"><i class="fi-comment" id="comment-count"> ' . count($info['Comments']) . '</i></a>
                    </div>
                    <hr class="comment-hr"/>
                    <div class="comment">';
                    foreach ($info['Comments'] as $comment) {
                        if (Session::get('username') == $this->username) {
                            $comment['Delete'] = 'fi-trash';
                        }
                   echo '<div class="row" id="post-' . $comment['CommentId'] . '">
                            <div class="large-2 columns small-3"><img src="'. $comment['Profile_pic'] .'"/></div>
                            <div class="large-10 columns">
                                <i id="tooltip-delete-box-' . $comment['CommentId'] . '" class="' . $comment['Delete'] . ' right has-tip delete-box" data-tooltip title="delete" onclick="delete_post(\'' . $comment['Commentor'] . '\',' . $comment['CommentId'] . ',\'' . COMMENT . '\')"></i>
                                <p>';
                                echo '<a href="'. URL . $comment['Commentor'] .'"><strong>' . $comment['Commentor'] . '</strong></a> &nbsp' . $comment['Comment'] . '
                                     <div class="date comment-date">' . $comment['Date'] . '</div>
                                </p>
                            </div>
                        </div>';
                    }
                    echo '   
                        <div class="row comment-box">
                            <div class="large-2 columns small">
                                <img class="comment-pic" src="'. $info['profile_pic_small'] .'"/>
                            </div>
                            <form class="large-10 columns comment-type-area" id="post-comment" method="post">
                                <textarea onkeydown="if (event.keyCode == 13) document.getElementById(\'commnet-submit\').click()" id="comment-post" name="comment-post" placeholder="Comment.."></textarea>
                                <input type="hidden" id="contentId" name="contentId" value="' . $info['id'] . '" />
                                <input class="hide" type="submit" id="commnet-submit" value="post" />
                            </form>
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

<div id="myModal" class="reveal-modal" data-reveal>
    <h2>Change your profile picture.</h2>
    <form enctype="multipart/form-data">
        <input type="file" name="profile-pic-uploading" id="profile-pic-uploading" accept="image" hidden/>
        <div class="button tiny radius" id="profile-pic-select">Select Image</div>
        <div class="button tiny radius" id="profile-pic-upload">Upload Image</div>
    </form>

    <div id="crop-container"></div>
</div>