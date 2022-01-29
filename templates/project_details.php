<?php $title = 'Clocker' ?>

<?php ob_start() ?>
    <div class="projects-page">
        <div class="project-add">
          <form class="project-main-form">
                
                
                <table id="myTable">
              <thead>
                <tr>
                  <th>Nazwa zadania</th>
                  <th>Śledzony czas</th>
                  <th>Data rozpoczęcia</th>
                  <th>Data zakończenia</th>
                  <th>Czas trwania</th>
                  <th>Edycja</th>
                </tr>
              </thead>
              <tbody id="names">
                <tr>
                  <td>Zadanie 1</td>
                  <td>21h 30m</td>
                  <td>01.01.2022r. 12:00</td>
                  <td>01.01.2022r. 12:00</td>
                  <td>01.01.2022r. 12:00</td>
                  <td><button type="button">Edycja</button></td>
                </tr>
                <tr>
                    <td>Zadanie 2</td>
                    <td>21h 30m</td>
                    <td>01.01.2022r. 12:00</td>
                    <td>01.01.2022r. 12:00</td>
                    <td>01.01.2022r. 12:00</td>
                    <td><button>Edycja</button></td>
                </tr>
              
               
              </tbody>
            </table>
         
            </form>


        </div>
    </div>
<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>