<?php $title = 'Clocker'?>

<?php ob_start()?>
    <main>
    <div class="clients-page">
        <div class="client">
        <form name="clientForm" action="/?action=clients_add" method="POST">
       <div class="input-client"> <input type="text" placeholder="Nazwa klienta" name="clientname" required/>
            <input type="text" class="input-client2" placeholder="Opis" name="description" required/>
            <button type="submit" class="login-button">Dodanie nowego clienta</button><div>
        </form>

        </div>
    </div>
   <div class="buttonclientadd"> <a href="/?action=clients" >Powrót</a></div>
    <main>

<?php $content = ob_get_clean()?>

<?php include 'additionalLayout.php'?>