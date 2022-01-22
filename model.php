<?php

function open_database_connection() {
    // development local database
    return new PDO("mysql:host=localhost;dbname=clocker", 'dev', '');
}

function close_database_connection(&$connection) {
    $connection = null;
}

function start_task($userID, $taskName) {
    $connection = open_database_connection();

    $statement = $connection->prepare("INSERT INTO task (userID, nameTask, startTime, status) 
                                                VALUES (:userID, :taskName, NOW(), 'inprogress')");

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

    $statement = $connection->prepare("UPDATE task SET stopTime=NOW(), status='inactive' WHERE id=:taskId");
    $statement->bindParam('taskId', $taskId, PDO::PARAM_INT);
    $statement->execute();

    setcookie("activeTaskId", "", time() - 3600);
    setcookie("activeTaskName", "", time() - 3600);
    setcookie("activeTaskStartTime", "", time() - 3600);

    close_database_connection($connection);
}

function register() {
    try{ 
        $connection = open_database_connection();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $username = $password = $confirm_password = $email = $lastname = "";
        $username_err = $password_err = $confirm_password_err =$email_err= "";
         
            if(empty(trim($_POST["username"]))){
                $username_err = "Please enter a username.";
                
            } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
                $username_err = "username can only contain letters, numbers, and underscores.";
    
            } else{$username=$_POST["username"];
    
                if(empty(trim($_POST["lastname"]))){
                    $username_err = "Please enter a ulastname.";
    
                } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["lastname"]))){
                    $username_err = "username can only contain letters, numbers, and underscores.";
    
                } else{ $lastname=$_POST["lastname"];
    
                    if(empty(trim($_POST["email"]))){
                        $email_err = "Please enter a email.";
    
                    } elseif(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', trim($_POST["email"]))){
                        $email_err = "Please enter a valid email.";
    
                    } else{
                        $email=$_POST["email"];
    
                $statement = $connection->prepare("SELECT username, email FROM user where username = :username OR email = :email");
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->bindParam(':email', $email, PDO::PARAM_STR);
                $statement->execute();
                $check=$statement->fetchall();
    
                if($statement->rowCount()>0){
                    $username_err= "This user already exists";
                }
                if(empty(trim($_POST["password"]))){
                    $password_err = "Please enter a password.";     
                } elseif(strlen(trim($_POST["password"])) < 6){
                    $password_err = "Password must have atleast 6 characters.";
                } else{
                    $password = trim($_POST["password"]);
                }
                
               
                if(empty(trim($_POST["confirm_password"]))){
                    $confirm_password_err = "Please confirm password.";     
                } else{
                    $confirm_password = trim($_POST["confirm_password"]);
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
            $param_lastname=$lastname;
            $param_email= $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            $param_user_type="user";
            
            $stmt=$connection->prepare("INSERT INTO user (username,lastname, email, password) VALUES (:username, :lastname, :email, :password)");
            $data = [
                'username'=>$param_username,
                'lastname'=>$param_lastname, 
                'email'=>$param_email,
                'password'=>$param_password  
            ];
            if($stmt->execute($data)){
                           
                echo "Goooood";
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }          
        }
          
           close_database_connection($connection);
        }catch(PDOException $e){
            echo  $e->getMessage();
       }
}

function login() {
    $username = $password = "";
    $username_err = $password_err = $username_err = "";
    $username =$_POST['username'];
    $password =$_POST['password'];
    if (!empty($_POST['username']) && !empty($_POST['password'])){
    try{
        $connection = open_database_connection();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare("SELECT * FROM user where username = :username");
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $check=$statement->fetch();
        if($statement->rowCount()>0){
                if(password_verify($password,$check["password"])){
                    session_start();
                    $_SESSION["user_login"]=$check["id"];
                    header("location: http://localhost/Clocker-main/client/pages/projects.php");
    
                }else{
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
    session_destroy();
    //header("location: http://localhost/Clocker-main/client/pages/logins.php");   
}
