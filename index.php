<?php

// load and initialize any global libraries
require_once 'model.php';
require_once 'controllers.php';

$requested_action = $_GET['action'] ?? 'home';

switch($requested_action) {
    case "home":
        home_action();
        break;
    case "register":
        register_action($_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
        break;
    case "login":
        login_action($_POST['username'], $_POST['password']);
        break;
    case "logout":
        logout();
        break;
    case "projects_details":
        if(user_logged_in()) {
        projects_details();
        redirect_home();
    } else {
        redirect_login();
    }
        break;
    case "projectDetail":
        if(user_logged_in()) {
            projectDetail();
            redirect_home();
        } else {
            redirect_login();
        }
            break;
    case "group":
        if(user_logged_in()) {
            group_action();
         redirect_home();
            } else {
             redirect_login();
          }
              break;
    case "password_recover":
        password_recover_action();
        break;
    case "startTask":
        if(user_logged_in()) {
            start_task_action($_POST['title'], $_POST['project']);
            redirect_home();
        } else {
            redirect_login();
        }
        break;
    case "stopTask":
        if(user_logged_in()) {
            stop_task_action();
            redirect_home();
        } else {
            redirect_login();
        }
        break;
    case "addManualTask":
        if(user_logged_in()) {
            add_manual_task_action($_POST['title'], $_POST['project'], $_POST['dateFrom'], $_POST['dateTo']);
            redirect_home();
        } else {
            redirect_login();
        }
        break;
    case "projects":
       projects_action();
        break;
    default:
        header('HTTP/1.1 404 Not Found');
        echo '<html><body><h1>Page Not Found!</h1></body></html>';
}
