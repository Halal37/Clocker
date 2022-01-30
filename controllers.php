<?php

use JetBrains\PhpStorm\NoReturn;

function home_action() {
    $user_count = count_users();
    $durations = get_durations();
    require 'templates/home.php';
}

function register_action($username, $firstname, $lastname, $email, $password, $confirm_password) {
    register($username, $firstname, $lastname, $email, $password, $confirm_password);
    require 'templates/register.php';
}

function login_action($username, $password) {
    login($username, $password);
    require 'templates/login.php';
}

function logout_action() {
    logout();
    require 'templates/login.php';
}

function password_recover_action() {
    require 'templates/password_recover.php';
}

function start_task_action($taskTitle, $taskProject) {
    start_task($_SESSION['user_login'], $taskTitle);     // TODO: zmienić na aktualnie zalogowanego usera i wybieranie projektu
}

function stop_task_action() {
    stop_task();
}

function add_manual_task_action($taskTitle, $taskProject, $dateFrom, $dateTo){ 
    add_manual_task($_SESSION['user_login'], 1, $taskTitle, $dateFrom, $dateTo); // TODO: zmienić na aktualnie zalogowanego usera i wybieranie projektu
}

function projects_action() {
    require 'templates/projects.php';
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

#[NoReturn] function redirect_home() {
    header( "Location: /?action=projects", true, 302);
    exit;
}

#[NoReturn] function redirect_login() {
    header( "Location: /?action=login", true, 302);
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