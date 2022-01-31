<?php

use JetBrains\PhpStorm\NoReturn;


function home_action() {
    $user_count = count_users();
    $durations = get_durations();
    require 'templates/home.php';
}

function register_action($username, $firstname, $lastname, $email, $password, $confirm_password)
{
    register($username, $firstname, $lastname, $email, $password, $confirm_password);
    require 'templates/register.php';
}

function login_action($username, $password)
{
    login($username, $password);
    require 'templates/login.php';
}

function logout_action()
{
    logout();
    require 'templates/login.php';
}

function password_recover_action()
{
    require 'templates/password_recover.php';
}

function start_task_action($taskTitle, $taskProject)
{
    start_task($_SESSION['user_login'], $taskTitle, $taskProject); // TODO: zmienić na aktualnie zalogowanego usera i wybieranie projektu
}

function stop_task_action()
{
    stop_task();
}

function add_manual_task_action($taskTitle, $taskProject, $dateFrom, $dateTo)
{
    add_manual_task($_SESSION['user_login'], $taskProject, $taskTitle, $dateFrom, $dateTo);
}

function projects_action()
{
    $projects = get_all_projects($_SESSION['user_login']);
    require 'templates/projects.php';
}

function get_projects_list_action(): array
{
    return get_all_projects($_SESSION['user_login']);
}

function project_details_action($id) {
    $project = get_project_by_id($id);
    $tasks = get_tasks_by_project_id($id);
    $clients = client_find();
    require 'templates/projectDetail.php';
}

#[NoReturn] function delete_project_action($id){
    delete_project($id);
    redirect_home();
}

function project_add_action($projectName, $rate){
    project_add($projectName, $rate);
    require 'templates/project_add.php';
}

#[NoReturn] function update_client_project_action($projectId, $clientId){
    update_client_project($projectId, $clientId);
}

function update_project_rate_action($projectId, $newRate) {
    update_project_rate($projectId, $newRate);
}

function clients_action()
{
    require 'templates/clients.php';
}

function clients_details_action($clientID)
{
    require 'templates/clients_details.php';

}

function clients_add_action($clientname, $description)
{
    clients_add($clientname, $description);
    require 'templates/clients_add.php';
}

function admin_action($id) {
    if(check_admin($id)) {
        $users = get_all_users();
        require 'templates/admin.php';
    } else {
        redirect_home();
    }
}

function edit_user_action($id, $userId) {
    if(check_admin($id)) {
        $user = get_user_by_id($userId);
        require 'templates/userEdit.php';
    } else {
        redirect_home();
    }
}

#[NoReturn] function update_user_action($loggedId, $userId, $username, $firstname, $lastname, $email) {
    if(check_admin($loggedId)) {
        update_user_with_id($userId, $username, $firstname, $lastname, $email);
        header( "Location: /?action=admin", true, 302);
        exit;
    } else {
        redirect_home();
    }
}

#[NoReturn] function delete_user_action($id, $userId) {
    if(check_admin($id)) {
        delete_user_with_id($userId);
        header( "Location: /?action=admin", true, 302);
        exit;
    } else {
        redirect_home();
    }
}

#[NoReturn]function redirect_home()
{
    header("Location: /?action=projects", true, 302);
    exit;
}

#[NoReturn]function redirect_login()
{
    header("Location: /?action=login", true, 302);
    exit;
}

function user_logged_in(): bool
{
    session_start();
    if (isset($_SESSION['user_login'])) {
        return true;
    } else {
        logout();
        return false;
    }
}
