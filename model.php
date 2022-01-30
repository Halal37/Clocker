<?php

require_once __DIR__ . '/vendor/autoload.php';

function open_database_connection(): PDO
{
    // development local database
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    return new PDO("mysql:host={$_ENV['DB_URL']};dbname={$_ENV['DB_DB']}", "{$_ENV['DB_USER']}", "{$_ENV['DB_PASS']}");
}

function close_database_connection(&$connection)
{
    $connection = null;
}

function start_task($userID, $taskName)
{
    $connection = open_database_connection();

    $statement = $connection->prepare("INSERT INTO task (userID, nameTask, startTime, status)
                                                VALUES (:userID, :taskName, NOW() + INTERVAL 1 HOUR, 'inprogress')");

    $statement->bindParam('userID', $userID, PDO::PARAM_INT);
    $statement->bindParam('taskName', $taskName);
    $statement->execute();

    $addedTaskId = $connection->lastInsertId();

    $stmt = $connection->query("SELECT nameTask, startTime FROM task WHERE id=$addedTaskId");
    $result = $stmt->fetch();

    setcookie("activeTaskId", $addedTaskId);
    setcookie("activeTaskName", $result['nameTask']);
    setcookie("activeTaskStartTime", $result['startTime']);

    close_database_connection($connection);
}

function stop_task()
{
    $connection = open_database_connection();

    $taskId = $_COOKIE['activeTaskId'];

    $statement = $connection->prepare("SELECT userID, nameTask FROM task WHERE id=:taskId");
    $statement->bindParam(':taskId', $taskId);
    $statement->execute();
    $result=$statement->fetch();

    if($result['userID'] == $_SESSION['user_login']) {
        $statement = $connection->prepare("UPDATE task SET stopTime=NOW() + INTERVAL 1 HOUR, status='inactive', duration=TIMEDIFF(stopTime, startTime) WHERE id=:taskId");
        $statement->bindParam('taskId', $taskId, PDO::PARAM_INT);
        $statement->execute();

        setcookie("activeTaskId", "", time() - 3600);
        setcookie("activeTaskName", "", time() - 3600);
        setcookie("activeTaskStartTime", "", time() - 3600);
    }

    close_database_connection($connection);
}

function add_manual_task($userID, $projectID, $taskName, $dateFrom, $dateTo)
{
    $datetimeFromConverted = new DateTime($dateFrom);
    $datetimeFromConverted = $datetimeFromConverted->format('Y-m-d H:i:s');

    $datetimeToConverted = new DateTime($dateTo);
    $datetimeToConverted = $datetimeToConverted->format('Y-m-d H:i:s');

    $connection = open_database_connection();

    $statement = $connection->prepare("INSERT INTO Task(userID, projectID, nameTask, startTime, stopTime, status, duration) 
                        VALUES(:userID, :projectID, :taskName, :datetimeFrom, :datetimeTo, 'inactive', TIMEDIFF(stopTime, startTime));");

    $statement->bindParam('userID', $userID, PDO::PARAM_INT);
    $statement->bindParam('projectID', $projectID, PDO::PARAM_INT);
    $statement->bindParam('taskName', $taskName);
    $statement->bindParam('datetimeFrom', $datetimeFromConverted);
    $statement->bindParam('datetimeTo', $datetimeToConverted);
    $statement->execute();

    close_database_connection($connection);
}

function register($username, $firstname, $lastname, $email, $password, $confirm_password)
{
    error_reporting(E_ALL&~E_NOTICE&~E_STRICT&~E_DEPRECATED&~E_WARNING);
    try {
        $connection = open_database_connection();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $username_err = $password_err = $confirm_password_err = $email_err = "";

        if (empty(trim($username))) {
            $username_err = "Please enter a username.";

        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))) {
            $username_err = "username can only contain letters, numbers, and underscores.";

        } else {

            if (empty(trim($lastname))) {
                $username_err = "Please enter a lastname.";

            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($lastname))) {
                $username_err = "username can only contain letters, numbers, and underscores.";

            } else {

                if (empty(trim($email))) {
                    $email_err = "Please enter a email.";

                } elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', trim($email))) {
                    $email_err = "Please enter a valid email.";

                } else {

                    $statement = $connection->prepare("SELECT username, email FROM user where username = :username OR email = :email");
                    $statement->bindParam(':username', $username, PDO::PARAM_STR);
                    $statement->bindParam(':email', $email, PDO::PARAM_STR);
                    $statement->execute();
                    $check = $statement->fetchall();

                    if ($statement->rowCount() > 0) {
                        $username_err = "This user already exists";
                    }
                    if (empty(trim($password))) {
                        $password_err = "Please enter a password.";
                    } elseif (strlen(trim($password)) < 6) {
                        $password_err = "Password must have at least 6 characters.";
                    } else {
                        $password = trim($password);
                    }

                    if (empty(trim($confirm_password))) {
                        $confirm_password_err = "Please confirm password.";
                    } else {
                        $confirm_password = trim($confirm_password);
                        if (empty($password_err) && ($password != $confirm_password)) {
                            $confirm_password_err = "Password did not match.";
                        }
                    }
                }
                echo $username_err;
                echo $password_err;
                echo $confirm_password_err;
                echo $email_err;
            }
        }

        if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {

            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $connection->prepare("INSERT INTO user (username,firstname,lastname, email, password) VALUES (:username, :firstname, :lastname, :email, :password)");
            $data = [
                'username' => $param_username,
                'firstname' => $param_firstname,
                'lastname' => $param_lastname,
                'email' => $param_email,
                'password' => $param_password,
            ];
            if ($stmt->execute($data)) {
                header("Location: /?action=login", true, 302);

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        close_database_connection($connection);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function login($username, $password)
{
    error_reporting(E_ERROR | E_PARSE);

    if (!empty($username) && !empty($password)){
    try{
        $connection = open_database_connection();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $connection->prepare("SELECT * FROM user where username = :username");
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $check=$statement->fetch();

        $statement = $connection->prepare("UPDATE user SET datatime=NOW() + INTERVAL 1 HOUR WHERE id=:id");
        $statement->bindParam('id', $check['id'], PDO::PARAM_INT);
        $statement->execute();

        if($statement->rowCount()>0){
            if(password_verify($password,$check["password"])) {
                session_start();

                if ($check["role"] == 'admin') {
                    $_SESSION["user_role"] = 'admin';
                }

                $_SESSION["user_login"]=$check["id"];
                $_SESSION["user_name"]=$check["firstname"] . " " . $check["lastname"];

                $words = explode(" ", $_SESSION["user_name"]);
                $initials = "";

                foreach ($words as $w) {
                    $initials .= $w[0];
                }

                    $_SESSION["user_initials"] = $initials;

                    header("Location: /?action=projects", true, 302);
                } else {
                    echo "Incorrect password";
                }
            } else {
                echo "This user does not exist";
            }
            close_database_connection($connection);
        } catch (PDOException $error) {
            echo $error->getMessage();
        }

    }
}

function check_admin($id): bool
{
    $connection = open_database_connection();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $connection->prepare("SELECT role FROM user WHERE id = :id");
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    $check=$statement->fetch();
    close_database_connection($connection);

    if($check['role'] == 'admin') {
        return True;
    }
    else{
        return False;
    }
}

function count_users() {
    $connection = open_database_connection();

    $statement = $connection->prepare("SELECT count(*) as user_count FROM user");
    $statement->execute();
    $count=$statement->fetch();

    close_database_connection($connection);

    return $count;
}

function get_durations(): array
{
    $connection = open_database_connection();

    $times = [];

    $statement = $connection->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS total_last_week FROM task 
            WHERE stopTime BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now();");
    $statement->execute();
    $total_last_week=$statement->fetch();
    $times[] = $total_last_week;

    $statement = $connection->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS total_last_month FROM task 
            WHERE stopTime BETWEEN date_sub(now(),INTERVAL 1 MONTH) AND now();");
    $statement->execute();
    $total_last_month=$statement->fetch();
    $times[] = $total_last_month;

    $statement = $connection->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS total_last_year FROM task 
            WHERE stopTime BETWEEN date_sub(now(),INTERVAL 1 YEAR) AND now();");
    $statement->execute();
    $total_last_year=$statement->fetch();
    $times[] = $total_last_year;

    $statement = $connection->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS total_time FROM task;");
    $statement->execute();
    $total_time=$statement->fetch();
    $times[] = $total_time;


    close_database_connection($connection);

    return $times;
}

function get_all_users(): array
{
    $connection = open_database_connection();

    $result = $connection->query(
        'SELECT u.id, u.username, SEC_TO_TIME(SUM(TIME_TO_SEC(t.duration))) AS total_time,u.datatime 
                    FROM user AS `u` LEFT JOIN task AS `t` ON t.userID=u.id GROUP BY u.id;');

    $users = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }

    close_database_connection($connection);

    return $users;
}

function get_user_by_id($id) {
    $connection = open_database_connection();

    $statement = $connection->prepare("SELECT * FROM user WHERE id = :id");
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    $user=$statement->fetch();

    close_database_connection($connection);

    return $user;
}

function delete_user_with_id($id) {
    $connection = open_database_connection();

    $statement = $connection->prepare("DELETE FROM user WHERE id = :id");
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    close_database_connection($connection);
}

function update_user_with_id($id, $username, $firstname, $lastname, $email) {
    $connection = open_database_connection();

    $statement = $connection->prepare("UPDATE user SET username=:username, firstname=:firstname, lastname=:lastname, email=:email WHERE id=:id");
    $statement->bindParam('id', $id, PDO::PARAM_INT);
    $statement->bindParam('username', $username);
    $statement->bindParam('firstname', $firstname);
    $statement->bindParam('lastname', $lastname);
    $statement->bindParam('email', $email);
    $statement->execute();

    close_database_connection($connection);
}

function logout(){
    session_start();
    setcookie("PHPSESSID", "", time() - 3600);
    session_destroy();
    session_write_close();
}

function clients_add($clientname, $description)
{
    $user_ID = $_SESSION["user_login"];
    $connection = open_database_connection();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $connection->prepare("SELECT * FROM client where  clientname = :clientname and userID = :userID");
    $statement->bindParam(':clientname', $clientname, PDO::PARAM_STR);
    $statement->bindParam(':userID', $user_ID, PDO::PARAM_STR);
    $statement->execute();
    $clientname_err = "";

    if ($statement->rowCount() > 0) {
        $clientname_err = "Client exist";
    }

    if (empty(trim($clientname))) {
        $clientname_err = "Please enter a clientname.";

    }
    if (empty($clientname_err)) {

        $stmt = $connection->prepare("INSERT INTO client (userID,clientName,description) VALUES (:userID, :clientName, :description)");
        $data = [
            'userID' => $user_ID,
            'clientName' => $clientname,
            'description' => $description,
        ];
        if ($stmt->execute($data)) {

        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    close_database_connection($connection);
}

function client()
{
    $user_ID = $_SESSION["user_login"];
    $connection = open_database_connection();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM client where userID=$user_ID";
    $row = $connection->query($query);
    ?>

    <?php
foreach ($row as $i) {
        ?>  <form name="clientForm" action="/?action=clients_details" method="POST">
            <a  id="login-link" class="link"><div class="circle-client"><?php echo substr($i["clientname"], 0, 1); ?></div></a>
            <div class="client-name">

            <?php echo $i["clientname"]; ?>

            <input type="hidden" name="details" value=<?php echo $i["id"]; ?>>
            <button type="submit" class="button-client">Szczegóły</a></div>
            </form>

    <?php
}
    close_database_connection($connection);

}

function client_details($clientID)
{
    $user_ID = $_SESSION["user_login"];
    $client_ID = $clientID;

    $connection = open_database_connection();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM project where userID=$user_ID and clientID=$client_ID";
    $row = $connection->query($query);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query2 = "SELECT clientname, description FROM client where userID=$user_ID and id=$client_ID";
    $row2 = $connection->query($query2);

    ?>

  <div class="client-name-title"><?php foreach ($row2 as $i) {echo $i["clientname"];
        $value = $i["description"];}?></div>
  <div class="client-name-details">Projekty </div>
  <div class="client-description"><?php echo $value; ?></div>

<?php
foreach ($row as $i) {
        ?>
        <div class="client-detail"><?php echo $i["projectName"]; ?></div>
<?php
}
    close_database_connection($connection);
}
?>