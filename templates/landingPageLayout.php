<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title ?> </title>
    <link href="style/reset.css" rel="stylesheet">
    <link href="style/style.css" rel="stylesheet">
    <link href="style/log_res.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
<header>
    <h1><a href="/?action=home"><i class="bi-alarm"></i>Clocker</a></h1>

    <div id="link-section">
        <a href="/?action=register" id="register-link" class="link">Rejestracja</a>
        <a href="/?action=login" id="login-link" class="link">Logowanie</a>
    </div>
</header>

<?= $content ?>
</body>

</html>