<?php $title = 'Clocker'?>

<?php ob_start()?>

    <div class="clients-page">
        <div class="client">

               <?php client_details($clientID); ?>

        </div>
    </div>
    <a href="/?action=clients" class="buttonclient">Powrót do klientów</a>

<?php $content = ob_get_clean()?>

<?php include 'additionalLayout.php'?>