<?php $title = 'Odzyskiwanie hasła' ?>

<?php ob_start() ?>
<div class="login-page">
    <div class="form">
        <form class="password-request-form">
            <input type="text" placeholder="Email"/>
            <button class="login-button">Odzyskaj</button>
        </form>
    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>
