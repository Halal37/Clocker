<?php $title = 'Logowanie' ?>

<?php ob_start() ?>
<div class="login-page">
    <div class="form">

        <form class="login-form">
            <input type="text" placeholder="Login"/>
            <input type="password" placeholder="Hasło"/>
            <p class="message">
                <a href="/?action=password_recover" id="foo">Nie pamiętasz hasła?</a>
            </p>
            <button class="login-button">Login</button>
        </form>

    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>
