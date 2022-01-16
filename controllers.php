<?php

function home_action() {
    require 'templates/home.php';
}

function register_action() {
    register();
    require 'templates/register.php';
}

function login_action() {
    login();
    require 'templates/login.php';
}

function password_recover_action() {
    require 'templates/password_recover.php';
}

function start_task_action($taskTitle, $taskProject) {
    start_task(1, $taskTitle);     // TODO: zmienić na aktualnie zalogowanego usera i wybieranie projektu
}

function stop_task_action() {
    stop_task();
}

function projects_action() {
    require 'templates/projects.php';
}

function redirect_home() {
    header( "Location: /?action=projects", true, 302);
    exit;
}