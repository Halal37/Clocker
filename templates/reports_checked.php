<?php $title = 'Clocker' ?>

<?php ob_start() ?>

<div class="raport-main">
    <p>Wygenerowano pomyślnie raport</p>
    <i class="bi-check2"></i>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>