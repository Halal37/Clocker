<?php $title = 'Clocker' ?>

<?php ob_start() ?>

    <form class="editUserForm" action="/?action=updateUser&id=<?= $user['id'] ?>" method="POST">
        <label for="username">Nazwa użytkownika</label>
        <input type="text" placeholder="Login" name="username" id="username" value="<?= $user['username'] ?>"/>

        <label for="firstname">Imię</label>
        <input type="text" placeholder="Imię" name="firstname" id="firstname" value="<?= $user['firstname'] ?>"/>

        <label for="lastname">Nazwisko</label>
        <input type="text" placeholder="Nazwisko" name="lastname" id="lastname" value="<?= $user['lastname'] ?>"/>

        <label for="email">Email</label>
        <input type="text" placeholder="Email" name="email" id="email" value="<?= $user['email'] ?>"/>

        <div>
            <button class="userEditBtn" type="submit" formmethod="post">Wyślij</button>
            <button class="userEditBtn btn-red"><a href="/?action=deleteUser&id=<?= $user['id'] ?>">Usuń</a></button>
        </div>
    </form>


<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>