<?php $title = 'Clocker' ?>

<?php ob_start() ?>

<main>
        <div class="app">
            <input type="text" id="searchInput" onkeyup="myFunction()" placeholder="Filtruj">
        
            <table id="myTable">
              <thead>
                <tr>
                  <th>Nazwa użytkownika</th>
                  <th>Śledzony czas</th>
                  <th>Data ostatniej aktywności</th>
                  <th>Edycja</th>
                </tr>
              </thead>
              <tbody id="names">
                <tr>
                  <td>Użytkownik 1</td>
                  <td>21h 30m</td>
                  <td>01.01.2022r. 12:00</td>
                  <td><button type="button">Edycja</button></td>
                </tr>
                <tr>
                    <td>Użytkownik 2</td>
                    <td>21h 30m</td>
                    <td>01.01.2022r. 12:00</td>
                    <td><button>Edycja</button></td>
                </tr>
                <tr>
                    <td>Użytkownik 3</td>
                    <td>21h 30m</td>
                    <td>01.01.2022r. 12:00</td>
                    <td><button>Edycja</button></td>
                </tr>
                <tr>
                    <td>Użytkownik 4</td>
                    <td>21h 30m</td>
                    <td>01.01.2022r. 12:00</td>
                    <td><button type = "button">Edycja</button></td>
                </tr>
               
              </tbody>
            </table>
          </div>

    </main>
<div id="cookie-alert">
    <div id="cookie-content">
        <!--            <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website.-->
        <b>Lubisz ciasteczka?</b> &#x1F36A; Używamy ciasteczek aby zapewnić Tobie jak najlepsze wrażenia z korzystania z naszego serwisu.
        <a href="https://cookiesandyou.com/" target="_blank">Dowiedz się więcej</a>
    </div>
    <div id="cookie-button">
        <button type="button" id="accept-cookies-btn">
            Zgadzam się
        </button>
    </div>
</div>

<script src="../cookie-alert.js"></script>
<script>function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }       
        }
      }
   
      
      </script>

<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>