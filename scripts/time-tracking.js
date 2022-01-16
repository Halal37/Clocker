const addTaskBtn = document.getElementById("addTaskBtn");
const stopTaskBtn = document.getElementById("stopTaskBtn");
const timer = document.getElementById("timer");

if (addTaskBtn) {
   addTaskBtn.addEventListener("click", () => {
      let background = document.createElement("div");
      let modal = document.createElement("div");
      let modalTitle = document.createElement("h4");
      let modalForm = document.createElement("form");
      let titleInput = document.createElement("input");
      let projectInput = document.createElement("input");
      let submitBtn = document.createElement("button");
      let exitIcon = document.createElement("i");
      let iframe = document.createElement("iframe");

      background.className = "addTaskBackground";
      modal.className = "addTaskModal"
      modalTitle.className = "modalTitle";
      modalTitle.innerText = "Śledź nowe zadanie!";
      modalForm.className = "modalForm";
      modalForm.action = '/?action=startTask';
      modalForm.method = 'POST';
      titleInput.name = "title";
      titleInput.className = "modalInput";
      titleInput.placeholder = "Podaj tytuł zadania";
      projectInput.name = "project";
      projectInput.className = "modalInput";
      projectInput.placeholder = "Wybierz projekt";
      submitBtn.className = "submitBtn";
      submitBtn.innerHTML = "<i class='bi-play-circle-fill'></i>";
      exitIcon.className = "exitIcon";
      exitIcon.innerHTML = "<i class='bi-x'></i>";
      iframe.name = "dummyframe";
      iframe.id = "dummyframe";
      iframe.style.display = "none";

      modalForm.appendChild(titleInput);
      modalForm.appendChild(projectInput);
      modalForm.appendChild(submitBtn);
      modal.appendChild(exitIcon);
      modal.appendChild(modalTitle);
      modal.appendChild(iframe);
      modal.appendChild(modalForm);

      document.body.appendChild(background);
      document.body.appendChild(modal);

      exitIcon.addEventListener("click", () => {
         document.body.removeChild(background);
         document.body.removeChild(modal);
      });

   });
}

if (timer) {
   /** Stores the reference to the elapsed time interval*/
   let elapsedTimeIntervalRef;

   /** Stores the start time of timer */
   let startTime;

   function getElapsedTime() {
      // Get startTime from Cookies
      let startTimeFromCookies = document.cookie
          .split('; ')
          .find(row => row.startsWith('activeTaskStartTime='))
          .split('=')[1];
      startTimeFromCookies = decodeURIComponent(startTimeFromCookies);

      // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
      let dateTimeParts= startTimeFromCookies.split(/[- :]/);
      // monthIndex begins with 0 for January and ends with 11 for December, so we need to decrement by one
      dateTimeParts[1]--;

      // our Date object
      const startTime = new Date(...dateTimeParts);

      // Record end time
      let endTime = new Date();

      // Compute time difference in milliseconds
      let timeDiff = endTime.getTime() - startTime.getTime();

      // Convert time difference from milliseconds to seconds
      timeDiff = timeDiff / 1000;

      // Extract integer seconds that dont form a minute using %
      let seconds = Math.floor(timeDiff % 60); //ignoring uncomplete seconds (floor)

      // Pad seconds with a zero if neccessary
      let secondsAsString = seconds < 10 ? "0" + seconds : seconds + "";

      // Convert time difference from seconds to minutes using %
      timeDiff = Math.floor(timeDiff / 60);

      // Extract integer minutes that don't form an hour using %
      let minutes = timeDiff % 60; //no need to floor possible incomplete minutes, becase they've been handled as seconds

      // Pad minutes with a zero if neccessary
      let minutesAsString = minutes < 10 ? "0" + minutes : minutes + "";

      // Convert time difference from minutes to hours
      timeDiff = Math.floor(timeDiff / 60);

      // Extract integer hours that don't form a day using %
      let hours = timeDiff % 24; //no need to floor possible incomplete hours, becase they've been handled as seconds

      // Convert time difference from hours to days
      timeDiff = Math.floor(timeDiff / 24);

      // The rest of timeDiff is number of days
      let days = timeDiff;

      let totalHours = hours + (days * 24); // add days to hours
      let totalHoursAsString = totalHours < 10 ? "0" + totalHours : totalHours + "";

      if (totalHoursAsString === "00") {
         return minutesAsString + ":" + secondsAsString;
      } else {
         return totalHoursAsString + ":" + minutesAsString + ":" + secondsAsString;
      }
   }

   timer.innerText = getElapsedTime(startTime);

   // Every second
   elapsedTimeIntervalRef = setInterval(() => {
      // Compute the elapsed time & display
      timer.innerText = getElapsedTime(startTime); //pass the actual record start time
   }, 1000);

   stopTaskBtn.addEventListener("click", () => {

   });

}
