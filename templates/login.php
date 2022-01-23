<?php $title = 'Logowanie' ?>

<?php ob_start() ?>
<div class="login-page">
    <div class="form">

    <form name="loginForm" action="/?action=login" method="POST">
        <input type="text" placeholder="Login" name="username" required/>
            <input type="password" placeholder="Hasło" name="password" required/>
            <p class="message">
                <a href="/?action=password_recover" id="foo">Nie pamiętasz hasła?</a>
            </p>
            <button type="submit" class="login-button">Login</button>
        </form>

    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>
