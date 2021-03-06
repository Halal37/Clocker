<?php

// load and initialize any global libraries
require_once 'model.php';
require_once 'controllers.php';

$requested_action = $_GET['action'] ?? 'home';

switch ($requested_action) {
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
        logout_action();
        break;
    case "password_recover":
        password_recover_action();
        break;
    case "startTask":
        if (user_logged_in()) {
            start_task_action($_POST['title'], $_POST['project']);
            redirect_home();
        } else {
            redirect_login();
        }
        break;
    case "stopTask":
        if (user_logged_in()) {
            stop_task_action();
            redirect_home();
        } else {
            redirect_login();
        }
        break;
    case "addManualTask":
        if (user_logged_in()) {
            add_manual_task_action($_POST['title'], $_POST['project'], $_POST['dateFrom'], $_POST['dateTo']);
            redirect_home();
        } else {
            redirect_login();
        }
        break;
    case "projects":
        if (user_logged_in()) {
            projects_action();
        } else {
            redirect_login();
        }
        break;
    case "getProjectsList":
        if (user_logged_in()) {
            header('Content-type: application/json');
            echo json_encode(get_projects_list_action());
        } else {
            redirect_login();
        }
        break;
    case "addProject":
        if (user_logged_in()) {
            project_add_action($_POST['projectname'], $_POST['rate']);
        } else {
            redirect_login();
        }
        break;
    case "projectDetails":
        if (user_logged_in()) {
            project_details_action($_GET['id']);
        } else {
            redirect_login();
        }
        break;
    case "updateRate":
        if (user_logged_in()) {
            update_project_rate_action($_GET['projectId'], $_GET['newRate']);
        } else {
            redirect_login();
        }
        break;
    case "delete_project":
        if (user_logged_in()) {
            delete_project_action($_GET['id']);
        } else {
            redirect_login();
        }
        break;
    case "clients":
        if (user_logged_in()) {
            clients_action();
        } else {
            redirect_login();
        }
        break;
    case "clients_add":
        if (user_logged_in()) {
            clients_add_action($_POST['clientname'], $_POST['description']);
        } else {
            redirect_login();
        }
        break;
    case "clients_details":
        if (user_logged_in()) {
            clients_details_action($_POST['details']);
        } else {
            redirect_login();
        }
        break;
    case "updateClient":
        if (user_logged_in()) {
            update_client_project_action($_GET['projectId'], $_GET['clientId']);
        } else {
            redirect_login();
        }
        break;
    case "admin":
        if(user_logged_in()) {
            admin_action($_SESSION["user_login"]);
        } else {
            redirect_login();
        }
        break;
    case "editUser":
        if(user_logged_in()) {
            edit_user_action($_SESSION["user_login"], $_GET['id']);
        } else {
            redirect_login();
        }
        break;
    case "updateUser":
        if(user_logged_in()) {
            update_user_action($_SESSION["user_login"], $_GET['id'], $_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['email']);
        } else {
            redirect_login();
        }
        break;
    
    case "deleteUser":
        if(user_logged_in()) {
            delete_user_action($_SESSION["user_login"], $_GET['id']);
        } else {
            redirect_login();
        }
        break;
    default:
        header('HTTP/1.1 404 Not Found');
        echo '<html><body><h1>Page Not Found!</h1></body></html>';
}
