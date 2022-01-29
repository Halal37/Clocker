<?php $title = 'Clocker'?>

<?php ob_start()?>
    <main>
    <div class="clients-page">
        <div class="client">

               <?phpclient_details($clientID);?>

        </div>
    </div>
    <a href="/?action=clients" class="buttonclient">Powrót do klientów</a>
    <main>
<?php $content = ob_get_clean()?>

<?php include 'additionalLayout.php'?>