<?php $title = 'Clocker' ?>

<?php ob_start() ?>

<div class="app">
    <input type="text" id="searchInput" onkeyup="myFunction()" placeholder="Filtruj">

    <table id="myTable">
      <thead>
        <tr>
          <th>Użytkownik</th>
          <th>Śledzony czas</th>
          <th>Ostatnio aktywny</th>
          <th>Edycja</th>
        </tr>
      </thead>
      <tbody id="names">
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= $user['username'] ?></td>
          <td><?= $user['total_time'] ?></td>
          <td><?= $user['datatime'] ?></td>
          <td><button type="button">
                  <a href="/?action=editUser&id=<?= $user['id'] ?>">
                      Edytuj
                  </a>
              </button></td>
        </tr>
      <?php endforeach ?>
<!--        <tr>-->
<!--            <td>Użytkownik 2</td>-->
<!--            <td>21h 30m</td>-->
<!--            <td>01.01.2022r. 12:00</td>-->
<!--            <td><button>Edycja</button></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Użytkownik 3</td>-->
<!--            <td>21h 30m</td>-->
<!--            <td>01.01.2022r. 12:00</td>-->
<!--            <td><button>Edycja</button></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Użytkownik 4</td>-->
<!--            <td>21h 30m</td>-->
<!--            <td>01.01.2022r. 12:00</td>-->
<!--            <td><button type = "button">Edycja</button></td>-->
<!--        </tr>-->

      </tbody>
    </table>
  </div>


<script>
    function myFunction() {
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