<!--
    @Author : Seungchul Lee
    @Date   : June 24, 2014
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
                <h4><a href="<?php echo URL . Session::get('username'); ?>"><?php echo Session::get('username'); ?></a></h5>
                    <div class="section-container side-nav" data-section data-options="deep_linking: false; one_up: true">
                        <section class="section">
                            <h6 style="font-size: 15px;" class="title"><a href="<?php echo URL; ?>setting">Setting</a></h6>
                        </section>
                        <section class="divider">
                            
                        </section>
                        <section class="title">
                            <h6 style="font-size: 15px;" class="title"><a href="#">Status</a></h6>
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
                <div class="large-2 columns small-3"><img src="http://placehold.it/80x80&text=[img]"/></div>
                <div class="large-10 columns">
                    <p><strong>Some Person said:</strong> Bacon ipsum dolor sit amet nulla ham qui sint exercitation eiusmod commodo, chuck duis velit. Aute in reprehenderit, dolore aliqua non est magna in labore pig pork biltong.</p>
                    <ul class="inline-list">
                        <li><a href="">Reply</a></li>
                        <li><a href="">Share</a></li>
                    </ul>


                    <h6>2 Comments</h6>
                    <div class="row">
                        <div class="large-2 columns small-3"><img src="http://placehold.it/50x50&text=[img]"/></div>
                        <div class="large-10 columns"><p>Bacon ipsum dolor sit amet nulla ham qui sint exercitation eiusmod commodo, chuck duis velit. Aute in reprehenderit</p></div>
                    </div>
                    <div class="row">
                        <div class="large-2 columns small-3"><img src="http://placehold.it/50x50&text=[img]"/></div>
                        <div class="large-10 columns"><p>Bacon ipsum dolor sit amet nulla ham qui sint exercitation eiusmod commodo, chuck duis velit. Aute in reprehenderit</p></div>
                    </div>
                </div>
            </div>


            <hr/>


            <div class="row">
                <div class="large-2 columns small-3"><img src="http://placehold.it/80x80&text=[img]"/></div>
                <div class="large-10 columns">
                    <p><strong>Some Person said:</strong> Bacon ipsum dolor sit amet nulla ham qui sint exercitation eiusmod commodo, chuck duis velit. Aute in reprehenderit, dolore aliqua non est magna in labore pig pork biltong.</p>
                    <ul class="inline-list">
                        <li><a href="">Reply</a></li>
                        <li><a href="">Share</a></li>
                    </ul>
                </div>
            </div>


            <hr/>


            <div class="row">
                <div class="large-2 columns small-3"><img src="http://placehold.it/80x80&text=[img]"/></div>
                <div class="large-10 columns">
                    <p><strong>Some Person said:</strong> Bacon ipsum dolor sit amet nulla ham qui sint exercitation eiusmod commodo, chuck duis velit. Aute in reprehenderit, dolore aliqua non est magna in labore pig pork biltong.</p>
                    <ul class="inline-list">
                        <li><a href="">Reply</a></li>
                        <li><a href="">Share</a></li>
                    </ul>


                    <h6>2 Comments</h6>
                    <div class="row">
                        <div class="large-2 columns small-3"><img src="http://placehold.it/50x50&text=[img]"/></div>
                        <div class="large-10 columns"><p>Bacon ipsum dolor sit amet nulla ham qui sint exercitation eiusmod commodo, chuck duis velit. Aute in reprehenderit</p></div>
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

<script>
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
