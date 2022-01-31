
<?php $title = 'Clocker' ?>

<?php ob_start() ?>
    <div class="projects-page">
        <div class="project-add">
          <form class="project-main-form">
                
                

                <table class="project-details-top">
                    <thead>
                        <tr>
                            <th ><?= $project['projectName'] ?></th>
                        </tr>
                    </thead>
                    <tr>
                        <th>
                            <span>Czas: <?= $project['total_time'] ?></span>
                            <span>Stawka:

                                <?php if ($project['rate'] != null) : ?>
                                    <span class="project-rate clickable-span"><?= $project['rate'] ?></span>
                                <?php else : ?>
                                    <span class="project-rate clickable-span">---</span>
                                <?php endif; ?>

                                zł/h
                            </span>
                            <span>Wypłata: <?php echo ($project['total_time'] * $project['rate']) . "zł" ?></span>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <span class="client-main-span">Klient:
                                <?php if ($project['clientname'] != null) : ?>
                                <span class="selected-client clickable-span"><?= $project['clientname'] ?></span>
                                <?php else : ?>
                                <span class="selected-client clickable-span">---</span>
                                <?php endif; ?>

                                <select name="client" class="client-select" style="display: none">
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?= $client['id'] ?>"><?= $client['clientname'] ?></option>
                                    <?php endforeach ?>
                                </select>

                            </span>
                        </th>
                    </tr>
<!--                    <tr>-->
<!--                        <th class="project-title">Zadania przypisane do projektu:</th>-->
<!--                    </tr>-->

                </table>


              <table class="project-tasks-table">
                <thead>
                <tr>
                    <th>Zadanie</th>
                    <th>Czas</th>
                    <th>Początek</th>
                    <th>Koniec</th>
                    <th>Kwota</th>
                </tr>

                </thead>
              <tbody>
              <?php foreach ($tasks as $task): ?>
                  <tr>
                      <td><?= $task['nameTask'] ?></td>
                      <td><?= $task['duration'] ?></td>
                      <td><?= $task['startTime'] ?></td>
                      <td><?= $task['stopTime'] ?></td>
                      <td><?php echo ($task['duration'] * $project['rate']) . "zł" ?></td>

                  </tr>
              <?php endforeach ?>

              </tbody>
              
            </table>

              <div class="buttons-project-detail">
                  <a href="/?action=delete_project&id=<?= $project['id'] ?>" class="button-delete">Usuń projekt</a>
                  <a href="#" class="button-add manual-task-add">Manualne dodanie zadania</a>
              </div>

           
            </form>


        </div>
    </div>

    <script>
        const addManualTaskBtn = document.querySelector(".manual-task-add");
        const addClientBtn = document.querySelector(".client-add-btn");
        const changeRateBtn = document.querySelector(".change-rate-btn");
        const selectedClient = document.querySelector(".selected-client");
        const clientSelect = document.querySelector(".client-select");
        const projectRate = document.querySelector(".project-rate");

        function compareDates(dateFrom, dateTo){
            dateFrom = new Date(dateFrom);
            dateTo = new Date(dateTo);

            return dateFrom > dateTo;
        }
        function createTaskPopup(){
            let background = document.createElement("div");
            let modal = document.createElement("div");
            let modalTitle = document.createElement("h4");
            let modalForm = document.createElement("form");
            let titleInput = document.createElement("input");
            let projectInput = document.createElement("input");
            let dateFrom = document.createElement("input");
            let dateTo = document.createElement("input");
            let submitBtn = document.createElement("button");
            let exitIcon = document.createElement("i");
            let iframe = document.createElement("iframe");

            background.className = "addTaskBackground";
            modal.className = "manualAddTaskModal"
            modalTitle.className = "modalTitle";
            modalTitle.innerText = "Śledź nowe zadanie!";
            modalForm.className = "modalForm";
            modalForm.action = '/?action=addManualTask';
            modalForm.method = 'POST';
            titleInput.name = "title";
            titleInput.className = "modalInput";
            titleInput.placeholder = "Podaj tytuł zadania";
            projectInput.name = "project";
            projectInput.type = "hidden";
            projectInput.value = <?= $project['id'] ?>
            // projectInput.className = "modalInput";
            // projectInput.placeholder = "Wybierz projekt";
            dateFrom.type = "datetime-local";
            dateFrom.name = "dateFrom";
            dateFrom.className = "modalInput";
            dateFrom.placeholder = "Od";
            dateTo.type = "datetime-local";
            dateTo.name = "dateTo";
            dateTo.className = "modalInput";
            dateTo.placeholder = "Do";
            submitBtn.className = "submitBtn";
            submitBtn.innerHTML = "<i class='bi-play-circle-fill'></i>";
            exitIcon.className = "exitIcon";
            exitIcon.innerHTML = "<i class='bi-x'></i>";
            iframe.name = "dummyframe";
            iframe.id = "dummyframe";
            iframe.style.display = "none";

            modalForm.appendChild(titleInput);
            modalForm.appendChild(projectInput);
            modalForm.appendChild(dateFrom);
            modalForm.appendChild(dateTo);
            modalForm.appendChild(submitBtn);
            modal.appendChild(exitIcon);
            modal.appendChild(modalTitle);
            modal.appendChild(iframe);
            modal.appendChild(modalForm);

            document.body.appendChild(background);
            document.body.appendChild(modal);


            //prevent user from entering earlier date than 'dateFrom'
            dateFrom.addEventListener("change", ()=>{
                if(compareDates(dateFrom.value, dateTo.value)){
                    dateFrom.value = dateTo.value;
                }
                dateTo.min = dateFrom.value;
            })
            //prevent user from entering later date than 'dateTo'
            dateTo.addEventListener("change", ()=>{
                if(compareDates(dateFrom.value, dateTo.value)){
                    dateTo.value = dateFrom.value;
                }
                dateFrom.max = dateTo.value;
            })
            //exit popup window
            exitIcon.addEventListener("click", ()=>{
                document.body.removeChild(background);
                document.body.removeChild(modal);
            });
        }
        function changeProjectRate() {
            let projectRateInput = document.createElement("input");
            projectRateInput.type = "number";
            projectRateInput.value = projectRate.innerHTML;
            projectRateInput.style.width = "50px";

            let submitBtn = document.createElement("button");
            submitBtn.type = "button";
            submitBtn.innerHTML = "Ok";

            projectRate.innerHTML = "";
            projectRate.appendChild(projectRateInput);
            projectRate.appendChild(submitBtn);
            projectRate.removeEventListener("click", changeProjectRate);

            submitBtn.addEventListener("click", () => {
                fetch(`/?action=updateRate&projectId=<?= $project['id'] ?>&newRate=${projectRateInput.value}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: 'PATCH'
                })

                window.location.reload();
            });

        }
        function changeClient() {
            let clientMainSpan = document.querySelector(".client-main-span");
            let submitBtn = document.createElement("button");
            submitBtn.type = "button";
            submitBtn.innerHTML = "Ok";
            submitBtn.style.height = "25px"

            selectedClient.style.display = "none";
            clientSelect.style.display = "inline-block";
            clientSelect.style.height = "25px";

            clientMainSpan.appendChild(submitBtn);

            submitBtn.addEventListener("click", () => {
                fetch(`/?action=updateClient&projectId=<?= $project['id'] ?>&clientId=${clientSelect.value}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: 'PATCH'
                })

                window.location.reload();
            })
        }


        addManualTaskBtn.addEventListener("click", createTaskPopup);
        selectedClient.addEventListener("click", changeClient);
        projectRate.addEventListener("click", changeProjectRate);

    </script>
<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>
