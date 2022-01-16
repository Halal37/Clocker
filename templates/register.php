<?php $title = 'Rejestracja' ?>
<?php function register_fun_action() {


require_once "connect.php";


$username = $password = $confirm_password = $email = $lastname = "";
$username_err = $password_err = $confirm_password_err =$email_err= "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "username can only contain letters, numbers, and underscores.";
    } else{
  
        $sql = "SELECT id FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
       
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
           
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
            
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    echo $username_err;

    
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } elseif(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', trim($_POST["email"]))){
        //$email_err = "email can only contain letters, numbers, and underscores.";
    } else{
      
        $sql = "SELECT id FROM user WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            
            $param_email= trim($_POST["email"]);
            
            
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
echo $email_err;
    echo "po mailu";
  
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
    echo $password_err;
    echo $confirm_password_err;
    $lastname=$_POST["lastname"];
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        
        $sql = "INSERT INTO user (username,lastname, email, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "ssss", $param_username,$param_lastname,$param_email, $param_password);
            
            
            $param_username = $username;
            $param_lastname=$lastname;
            $param_email= $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
                     
            print_r($stmt);
           
            if(mysqli_stmt_execute($stmt)){
                
                printf("%d row inserted.\n", mysqli_stmt_affected_rows($stmt));
                header("Location: /?action=login"); 
            } else{
                echo "Error description: " . mysqli_error($link);
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
  
    
    mysqli_close($link);
}


}?>
<?php ob_start() ?>
<div class="login-page">
    <div class="form">
        <form class="register-form">

        <form name="registrationform" action="/?action=register_fun" method="post" enctype="application/x-www-form-urlencoded"> 
            <input type="text" placeholder="Login" name="username"/>
            <input type="text" placeholder="Nazwisko" name="lastname"/>
            <input type="text" placeholder="Email" name="email"/>
            <input type="password" placeholder="Haslo" name="password"/>
            <input type="password" placeholder="Powtorz haslo" name="confirm_password"/>
            <button class="login-button">Zarejestruj</button>
        </form>

    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>
