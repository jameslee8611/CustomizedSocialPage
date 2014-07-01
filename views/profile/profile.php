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
        <div class="large-12 columns">

            <div class="row">
                <div class="large-12 hide-for-small">

                    <div id="featured" data-orbit>
                        <img src="http://placehold.it/1200x500&text=Slide Image 1" alt="slide image">
                        <img src="http://placehold.it/1200x500&text=Slide Image 2" alt="slide image">
                        <img src="http://placehold.it/1200x500&text=Slide Image 3" alt="slide image">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="large-12 columns show-for-small">

                    <img src="http://placehold.it/1200x700&text=Mobile Header">

                </div>
            </div><br>
            
            <div class="row">
                <div class="large-12 columns">
                    <form class="post-form">
                        <ul class="tabs" data-tab>
                            <li class="tab-title"><a class="post-icon" href="#image"><i class="fi-photo"></i></a></li>
                            <li class="tab-title"><a class="post-icon" href="#video"><i class="fi-video"></i></a></li>
                        </ul>
                        <div class="tabs-content custom">
                            <div class="content custom" id="image">Image<i class="fi-x"></i></div>
                            <div class="content custom" id="video">Video<i class="fi-x"></i></div>
                        </div>
                        <div class="post-container">
                            <textarea id="post-textarea" rows="3" placeholder="Type Content to Post"></textarea>
                            <div id="post-friends" class="row custom" hidden>
                                <div class="large-6 columns custom">
                                    <a href="#" data-dropdown="tag-friends" class="custom-tiny radius button dropdown"><i class="fi-torsos-all"></i></a>
                                    <ul id="tag-friends" class="f-dropdown" data-dropdown-content>
                                        <li>Lee</li>
                                        <li>Yoon</li>
                                        <li>Song</li>
                                    </ul>
                                </div>
                                <div class="large-6 columns custom">
                                    <input class="custom-tiny radius button post-button" type="submit" value="Post"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><br>
            <div class="row">
                <div class="large-6 columns">
                    <?php echo $this->post; ?>
                </div>
                <div class="large-6 columns">
                    <?php echo $this->comment; ?>
                </div>
            </div><br>

            <div class="row">
                <div class="large-12 columns">
                    <div class="row">

                        <div class="large-4 small-6 columns">

                            <h4>Upcoming Shows</h4><hr>

                            <div class="row">
                                <div class="large-1 column">
                                    <img src="http://placehold.it/50x50&text=[img]">
                                </div>

                                <div class="large-9 columns">
                                    <h5><a href="#">Venue Name</a></h5>
                                    <h6 class="subheader show-for-small">Doors at 00:00pm</h6>
                                </div>
                            </div><hr>

                            <div class="hide-for-small">
                                <div class="row">
                                    <div class="large-1 column">
                                        <img src="http://placehold.it/50x50&text=[img]">
                                    </div>

                                    <div class="large-9 columns">
                                        <h5 class="subheader"><a href="#">Venue Name</a></h5>
                                    </div>
                                </div><hr>

                                <div class="row">
                                    <div class="large-1 column">
                                        <img src="http://placehold.it/50x50&text=[img]">
                                    </div>

                                    <div class="large-9 columns">
                                        <h5 class="subheader"><a href="#">Venue Name</a></h5>
                                    </div>
                                </div><hr>

                                <div class="row">
                                    <div class="large-1 column">
                                        <img src="http://placehold.it/50x50&text=[img]">
                                    </div>

                                    <div class="large-9 columns">
                                        <h5 class="subheader"><a href="#">Venue Name</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="large-4 small-6 columns">
                            <img src="http://placehold.it/300x465&text=Image">
                        </div>

                        <div class="large-4 small-12 columns">

                            <h4>Blog</h4><hr>
                            <div class="panel">
                                <h5><a href="#">Post Title 1</a></h5>

                                <h6 class="subheader">
                                    Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Suspendisse ultrices ornare tempor...
                                </h6>

                                <h6><a href="#">Read More »</a></h6>
                            </div>

                            <div class="panel hide-for-small">
                                <h5><a href="#">Post Title 2 »</a></h5>
                            </div>

                            <div class="panel hide-for-small">
                                <h5><a href="#">Post Title 3 »</a></h5>
                            </div>

                            <a href="#" class="right">Go To Blog »</a>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<script>
    document.write('<script src=<?php echo URL; ?>public/js/vendor/' +
            ('__proto__' in {} ? 'zepto' : 'jquery') +
            '.js><\/script>');
</script>
<script>
    $(document).foundation();
    $('.tab-title').click(function(){
        if($(this).hasClass('active')){
            var deact_target = $(this).children().attr('href')
            $(this).removeClass('active');
            $(deact_target).removeClass('active');
            return false;
        }
    });
    $('#post-textarea').click(function(){
        $('#post-friends').show();
    });
</script>
