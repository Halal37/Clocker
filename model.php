<?php

require_once __DIR__ . '/vendor/autoload.php';

function open_database_connection(): PDO
{
    // development local database
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    return new PDO("mysql:host={$_ENV['DB_URL']};dbname={$_ENV['DB_DB']}", "{$_ENV['DB_USER']}", "{$_ENV['DB_PASS']}");
}

function close_database_connection(&$connection) {
    $connection = null;
}

function start_task($userID, $taskName) {
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

function stop_task() {
    $connection = open_database_connection();

    $taskId = $_COOKIE['activeTaskId'];
    echo $taskId;
    // TODO: zmienić na ID konkretnego użytkownika, żeby nie móc zmienić statusu innemu użytkownikowi

    $statement = $connection->prepare("UPDATE task SET stopTime=NOW() + INTERVAL 1 HOUR, status='inactive' WHERE id=:taskId");
    $statement->bindParam('taskId', $taskId, PDO::PARAM_INT);
    $statement->execute();

    setcookie("activeTaskId", "", time() - 3600);
    setcookie("activeTaskName", "", time() - 3600);
    setcookie("activeTaskStartTime", "", time() - 3600);

    close_database_connection($connection);
}

function add_manual_task($userID, $projectID, $taskName, $dateFrom, $dateTo){
    $datetimeFromConverted = new DateTime($dateFrom);
    $datetimeFromConverted = $datetimeFromConverted->format('Y-m-d H:i:s');

    $datetimeToConverted = new DateTime($dateTo);
    $datetimeToConverted = $datetimeToConverted->format('Y-m-d H:i:s');

    $connection = open_database_connection();

    $statement = $connection->prepare("INSERT INTO Task(userID, projectID, nameTask, startTime, stopTime, status) 
                        VALUES(:userID, :projectID, :taskName, :datetimeFrom, :datetimeTo, 'inactive');");

    $statement->bindParam('userID', $userID, PDO::PARAM_INT);
    $statement->bindParam('projectID', $projectID, PDO::PARAM_INT);
    $statement->bindParam('taskName', $taskName);
    $statement->bindParam('datetimeFrom', $datetimeFromConverted);
    $statement->bindParam('datetimeTo', $datetimeToConverted);

    $statement->execute();

    close_database_connection($connection);
}

function register($username, $firstname, $lastname, $email, $password, $confirm_password) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
    try{ 
        $connection = open_database_connection();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $username_err = $password_err = $confirm_password_err =$email_err= "";
         
            if(empty(trim($username))){
                $username_err = "Please enter a username.";
                
            } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
                $username_err = "username can only contain letters, numbers, and underscores.";
    
            } else{

                if(empty(trim($lastname))){
                    $username_err = "Please enter a lastname.";
    
                } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($lastname))){
                    $username_err = "username can only contain letters, numbers, and underscores.";
    
                } else{

                    if(empty(trim($email))){
                        $email_err = "Please enter a email.";
    
                    } elseif(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', trim($email))){
                        $email_err = "Please enter a valid email.";
    
                    } else{

                $statement = $connection->prepare("SELECT username, email FROM user where username = :username OR email = :email");
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->bindParam(':email', $email, PDO::PARAM_STR);
                $statement->execute();
                $check=$statement->fetchall();
    
                if($statement->rowCount()>0){
                    $username_err= "This user already exists";
                }
                if(empty(trim($password))){
                    $password_err = "Please enter a password.";     
                } elseif(strlen(trim($password)) < 6){
                    $password_err = "Password must have at least 6 characters.";
                } else{
                    $password = trim($password);
                }
                
               
                if(empty(trim($confirm_password))){
                    $confirm_password_err = "Please confirm password.";     
                } else{
                    $confirm_password = trim($confirm_password);
                    if(empty($password_err) && ($password != $confirm_password)){
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
        
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
               
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname=$lastname;
            $param_email= $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt=$connection->prepare("INSERT INTO user (username,firstname,lastname, email, password) VALUES (:username, :firstname, :lastname, :email, :password)");
            $data = [
                'username'=>$param_username,
                'firstname'=>$param_firstname,
                'lastname'=>$param_lastname, 
                'email'=>$param_email,
                'password'=>$param_password  
            ];
            if($stmt->execute($data)){
                header( "Location: /?action=login", true, 302);

            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }          
        }
          
           close_database_connection($connection);
        }catch(PDOException $e){
            echo  $e->getMessage();
       }
}

function login($username, $password) {
    error_reporting(E_ERROR | E_PARSE);

    if (!empty($username) && !empty($password)){
    try{
        $connection = open_database_connection();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare("SELECT * FROM user where username = :username");
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $check=$statement->fetch();
        if($statement->rowCount()>0){
            if(password_verify($password,$check["password"])) {
                session_start();

                $_SESSION["user_login"]=$check["id"];
                $_SESSION["user_name"]=$check["firstname"] . " " . $check["lastname"];

                $words = explode(" ", $_SESSION["user_name"]);
                $initials = "";

                foreach ($words as $w) {
                    $initials .= $w[0];
                }

                $_SESSION["user_initials"]=$initials;

                header( "Location: /?action=projects", true, 302);
            } else {
                echo "Incorrect password";
            }
        }else{
           echo "This user does not exist"; 
        }
        close_database_connection($connection);
    }catch(PDOException $error){
        echo $error->getMessage();
    }
    
     }
}

function logout(){
    session_start();
    setcookie("PHPSESSID", "", time() - 3600);
    session_destroy();
    session_write_close();
}
