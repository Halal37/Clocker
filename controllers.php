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

function upload_task_action($userID, $taskName) {
    upload_task($userID, $taskName);
//    require 'templates/uploadTask.php';
}