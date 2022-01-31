<?php $title = 'Clocker'?>


<?php ob_start() ?>
    <div class="projects-page">
        <?php foreach ($projects as $project): ?>
            <div class="project">
                <form class="project-main-form">
                    <div class="project-name"><?= $project['projectName'] ?></div>
                    <div class="number-of-tasks">Liczba zadań: <?= $project['task_count'] ?></div>
                    <div class="clients">Klient: <?= $project['clientname'] ?></div>
                    <a class="button" href="/?action=projectDetails&id=<?= $project['id'] ?>">
                        Szczegóły
                    </a>
                </form>
            </div>
        <?php endforeach ?>

        <a class="button add-project-btn" href="/?action=addProject">
            Dodaj projekt
        </a>

    </div>

<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php'?>