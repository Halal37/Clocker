
<?php $title = 'Clocker' ?>

<?php ob_start() ?>
    <main>
    <div class="projects-page">
        <div class="project-add">
          <form class="project-main-form">
                
                
                <table id="myTable">
              <thead>
                <tr>
                <th >Projekt 1</th>
                  <th><span>
                  Czas:21h
                  </span><span>Klient:XXX</span> </th>
                </tr>
                <tr><th class="project-title">Zadania przypisane do projektu:</th>
          
            </tr>
              </thead>
              <tbody id="names">
              <tr>
                  <td>Zadanie 1</td>
                
                  <td class="button-detail"><button type="button"><a href="/?action=projects_details">Szczegóły</a></button></td>
                </tr>
                <tr>
                    <td>Zadanie 2</td>
                
                    
                    <td class="button-detail"><button type="button" ><a href="/?action=projects_details">Szczegóły</a></button></td>
                </tr>
              
               <tr ><td colspan="1"><td class="common-buttons"><a href="#" class="button-project">Usuń zadanie</a>
           <a href="#" class="button-add">Manualne dodanie</a></td></tr>
              </tbody>
              
            </table>
           
            </form>


        </div>
    </div>
    <main>
<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>
