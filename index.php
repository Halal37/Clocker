<?php

// load and initialize any global libraries
require_once 'model.php';
require_once 'controllers.php';

if (isset($_GET['action'])) {
    $requested_action = $_GET['action'];
}
else {
    $requested_action = 'home';
}

switch($requested_action) {
    case "home":
        home_action();
        break;
    case "register":
        register_action();
        break;
    case "login":
        login_action();
        break;
    case "password_recover":
        password_recover_action();
        break;
    case "uploadTask":
        upload_task_action($_GET['userID'], $_GET['taskName']);
        break;
    default:
        header('HTTP/1.1 404 Not Found');
        echo '<html><body><h1>Page Not Found!</h1></body></html>';
}