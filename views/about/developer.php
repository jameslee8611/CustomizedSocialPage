<!--
    @Author : Seungchul Lee
    @Date   : August 16, 2014
-->

<?php if (Session::get('loggedIn')): ?>
<div class="content about">
<?php else: ?>
<div class="conetnet-child about">
<?php endif; ?>
    <h2>Our Developers</h2>
    <div class="row">
        <div class="large-6 small-6 columns">
            <img src="http://placehold.it/400x300&amp;text=[img]">
            <h4>Seungchul Lee</h4>
            <p>In this project, I am acting as a full-stack engineer, focusing on overall structure and functionalities for this web application (Database & Backend)</p>
            <p>You can reach me out through <a href="https://www.linkedin.com/pub/seungchul-lee/77/7b1/90b/" target="blank"> LinkedList</a></p>
            <p>And here is my personal website: <a href="https://sites.google.com/site/sclee8611/" target="blank">Click here..</a></p>
        </div>
        <div class="large-6 small-6 columns">
            <img src="http://placehold.it/400x300&amp;text=[img]">
            <h4>Jae Yun Song</h4>
            <p>Here, I am taking care of the front-end jobs for this website. However, I am also taking a responsibility for uploading & showing images on the page.</p>
        </div>
    </div>
</div>
