<?php $title = 'Rejestracja' ?>

<?php ob_start() ?>
<div class="login-page">
    <div class="form">
        <form class="register-form">

        <form name="registrationform" action="/?action=register" method="POST">
            <input type="text" placeholder="Login" name="username"/>
            <input type="text" placeholder="Imię" name="firstname"/>
            <input type="text" placeholder="Nazwisko" name="lastname"/>
            <input type="text" placeholder="Email" name="email"/>
            <input type="password" placeholder="Haslo" name="password"/>
            <input type="password" placeholder="Powtorz haslo" name="confirm_password"/>
            <button type="submit" formmethod="post" class="login-button">Zarejestruj</button>
        </form>

    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>
