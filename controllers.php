<?php

function home_action() {
    require 'templates/home.php';
}

function register_action() {
    require 'templates/register.php';
}

function login_action() {
    require 'templates/login.php';
}

function password_recover_action() {
    require 'templates/password_recover.php';
}

function start_task_action($taskTitle, $taskProject) {
    start_task(1, $taskTitle);     // zmienić na aktualnie zalogowanego usera
}

function stop_task_action() {
    stop_task();
}

function redirect_home() {
    header( "Location: /", true, 302);
    exit;
}