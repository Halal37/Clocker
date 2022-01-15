<?php $title = 'Rejestracja' ?>

<?php ob_start() ?>
<div class="login-page">
    <div class="form">
        <form class="register-form">

            <input type="text" placeholder="Login"/>
            <input type="text" placeholder="Nazwisko"/>
            <input type="text" placeholder="Email"/>
            <input type="password" placeholder="Haslo"/>
            <input type="password" placeholder="Powtorz haslo"/>
            <button class="login-button">Zarejestruj</button>
        </form>

    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>
