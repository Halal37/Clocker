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

function project_action() {
    require 'templates/projects.php';
}

function admin_action() {
    require 'templates/admin.php';
}


function reports_checked_action() {
    require 'templates/reports_checked.php';
}



function upload_task_action($userID, $taskName) {
    upload_task($userID, $taskName);
//    require 'templates/uploadTask.php';
}