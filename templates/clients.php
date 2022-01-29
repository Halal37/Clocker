<?php $title = 'Clocker'?>

<?php ob_start()?>
    <main>
    <div class="clients-page">
        <div class="client">

           <?php client()?>

        </div>
    </div>
    <a href="/?action=clients_add" class="buttonclient">Dodaj nowego klienta</a>
    <main>
<?php $content = ob_get_clean()?>

<?php include 'additionalLayout.php'?>