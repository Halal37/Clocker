const addManualTaskBtn = document.querySelector(".project-main-form .button");

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
    modal.className = "addTaskModal"
    modalTitle.className = "modalTitle";
    modalTitle.innerText = "Śledź nowe zadanie!";
    modalForm.className = "modalForm";
    modalForm.action = '/?action=addManualTask';
    modalForm.method = 'POST';
    titleInput.name = "title";
    titleInput.className = "modalInput";
    titleInput.placeholder = "Podaj tytuł zadania";
    projectInput.name = "project";
    projectInput.className = "modalInput";
    projectInput.placeholder = "Wybierz projekt";
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

    //exit popup window
    exitIcon.addEventListener("click", ()=>{
        document.body.removeChild(background);
        document.body.removeChild(modal);
    });
}

addManualTaskBtn.addEventListener("click", createTaskPopup);
