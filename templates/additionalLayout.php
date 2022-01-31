<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title ?> </title>
    <link href="style/reset.css" rel="stylesheet">
    <link href="style/style.css" rel="stylesheet">
    <link href="style/start_stop_topbar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <header>

<!--        style="   --><?php //if(isset($_COOKIE['activeTaskName'])) : ?>
<!--            width: calc(100% - 330px);-->
<!--            justify-content: space-between;-->
<!--        --><?php //else : ?>
<!--            justify-content: flex-end;-->
<!--        --><?php //endif ?><!--"-->

        <!--  Dodawanie nowego zadania, start i stop czasu  -->
        <div id="top-bar" >

            <div id="topbar-left-section">
                <i class="bi-list" id="openMenuBtn"></i>

                <?php if(isset($_COOKIE['activeTaskName'])) : ?>
                    <p id="activeTaskTitle"><?= $_COOKIE['activeTaskName'] ?></p>
                <?php endif ?>
            </div>

            <div id="link-section">

                <?php if(isset($_COOKIE['activeTaskName'])) : ?>
                    <p id="timer"></p>
                    <a href="/?action=stopTask"><i id="stopTaskBtn" class="bi-stop-circle"></i></a>
                <?php else : ?>
                    <i id="addTaskBtn" class="bi-plus-circle-dotted"></i>
                <?php endif ?>

                <i class="username-topbar"><?php echo $_SESSION['user_name'] ?></i>
                <a href="/?action=logout" id="login-link" class="link"><div class="circle"><?php echo $_SESSION['user_initials'] ?></div></a>
            </div>
        </div>

    </header>

    <nav id="mobile-menu" style="display: none">
        <i class="bi-x" id="close-menu-btn"></i>
        <h1 class="main-logo"><a href="/?action=projects"><i class="bi-alarm"></i>Clocker</a></h1>
        <a href="/?action=projects"><i class="bi-files"></i>Projekty</a>
        <a href="/?action=history"><i class="bi-clock-history"></i>Historia</a>
        <a href="/?action=clients"><i class="bi-cash"></i>Klienci</a>
        <a href="/?action=reports"><i class="bi-file-bar-graph"></i>Raporty</a>
        <?php if($_SESSION["user_role"] == 'admin') : ?>
            <a href="/?action=admin"><i class="bi-people-fill"></i>Administracja</a>
        <?php endif ?>
    </nav>

    <nav id="desktop-menu">
        <h1 class="main-logo"><a href="/?action=projects"><i class="bi-alarm"></i>Clocker</a></h1>
        <a href="/?action=projects"><i class="bi-files"></i>Projekty</a>
        <a href="/?action=history"><i class="bi-clock-history"></i>Historia</a>
        <a href="/?action=clients"><i class="bi-cash"></i>Klienci</a>
        <a href="/?action=reports"><i class="bi-file-bar-graph"></i>Raporty</a>
        <?php if($_SESSION["user_role"] == 'admin') : ?>
        <a href="/?action=admin"><i class="bi-people-fill"></i>Administracja</a>
        <?php endif ?>
    </nav>

    <main>
        <div class="main-content">
            <?= $content ?>
        </div>
    </main>
    <script src="../scripts/time-tracking.js"></script>
    <script src="../scripts/mobileMenu.js"></script>
</body>

</html>