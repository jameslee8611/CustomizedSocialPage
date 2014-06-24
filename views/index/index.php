<?php if (Session::get('loggedIn') == true): ?>
Main Page
<?php else: include_once 'signup.php'; ?>

<?php endif; ?>