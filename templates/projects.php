<?php $title = 'Clocker' ?>

<?php ob_start() ?>

    <div class="projects-page">
        <div class="project">
          <form class="project-main-form">
                <div class="project-name">Projekt 1</div>

                <div class="number-of-tasks">Lista zadań: 5</div>
                <div class="client-name">Klient: XXX</div>
                <a href="#" class="button">Szczegóły</a>
            </form>


        </div>
    </div>

<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>