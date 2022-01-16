<?php $title = 'Clocker' ?>

<?php ob_start() ?>

<main class="raport-main">
    <p>Wygenerowano pomyślnie raport</p>
    <i class="bi-check2"></i>
</main>

<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>