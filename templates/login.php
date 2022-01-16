<?php $title = 'Logowanie' ?>
<?php function login_fun_action() {

require_once "connect.php";
$username = $password = "";
$username_err = $password_err = $username_err = "";
session_start();
print_r($_POST);
if (!empty($_POST['username']) && !empty($_POST['password']))
{
  $sql = "SELECT id, username, password FROM user WHERE username = ?";

  if($stmt = mysqli_prepare($link, $sql)){

    mysqli_stmt_bind_param($stmt, "s", $param_username);
    

    $param_username = $_POST['username'];
    $password=$_POST['password'];
    echo $param_username;
 
    if(mysqli_stmt_execute($stmt)){

        echo "Print";
        mysqli_stmt_store_result($stmt);
        

        if(mysqli_stmt_num_rows($stmt) == 1){                    

            echo "Print";
            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password, $hashed_password)){
                  echo "Print";

                    session_start();
                    

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;                            
                    

                    header("Location: /?action=projects"); 
                } else{

                    $username_err = "Invalid username or password.";
                }
            }
        } else{

            $username_err = "Invalid username or password.";
            echo $username_err;
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }


    mysqli_stmt_close($stmt);
}
}


}?>
<?php ob_start() ?>
<div class="login-page">
    <div class="form">

    <form name="registrationform" action="/?action=login_fun" method="post" enctype="application/x-www-form-urlencoded"> 
        <input type="text" placeholder="Login" name="login" required/>
            <input type="password" placeholder="Hasło" name="password" required/>
            <p class="message">
                <a href="/?action=password_recover" id="foo">Nie pamiętasz hasła?</a>
                </p>
            <button class="login-button">Login</button>
        </form>

    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>
