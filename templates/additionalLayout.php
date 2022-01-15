<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title ?> </title>
    <link href="style/reset.css" rel="stylesheet">
    <link href="style/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <header>
        
        
        <h1><a href="index.html"><i class="bi-alarm"></i>Clocker</a></h1>
        <div id="link-section">
            <a href="#" id="register-link" class="link"><i class="bi-plus-circle-dotted"></i></a>
            <a href="#">User</a>
            <a href="./index_old_theme.html" id="login-link" class="link"><div class="circle">U</div></a>
        </div>
    </header>
    <nav>
        <h1 class="main-logo"><a href="index.html"><i class="bi-alarm"></i>Clocker</a></h1>
        <a href="/?action=projects"><i class="bi-files"></i>Projekty</a>
        <a href="/?action=history"><i class="bi-clock-history"></i>Historia</a>
        <a href="/?action=groups"><i class="bi-people"></i>Grupy</a>
        <a href="/?action=clients"><i class="bi-cash"></i>Klienci</a>
        <a href="/?action=reports"><i class="bi-file-bar-graph"></i>Raporty</a>


    </nav>
    <?= $content ?>

</body>

</html>