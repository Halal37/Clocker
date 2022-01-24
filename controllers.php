<?php

use JetBrains\PhpStorm\NoReturn;

function home_action() {
    require 'templates/home.php';
}

function projects_details() {
    require 'templates/project_details.php';
}
function projectDetail() {
    require 'templates/projectDetail.php';
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