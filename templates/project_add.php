<?php $title = 'Clocker'?>

<?php ob_start()?>

    <div class="clients-page">
        <div class="client">
            <form name="clientForm" action="/?action=addProject" method="POST">
                <div class="input-client">
                    <input type="text" placeholder="Nazwa projektu" name="projectname" required/>
                    <input type="number" placeholder="Stawka" name="rate" required/>
                    <button type="submit" class="login-button">Dodanie nowego projektu</button>
                </div>
            </form>

        </div>
    </div>

    <div class="buttonclientadd">
        <a href="/?action=projects" >Powrót</a>
    </div>


<?php $content = ob_get_clean()?>

<?php include 'additionalLayout.php'?>