<?php

function open_database_connection() {
    // development local database
    return new PDO("mysql:host=localhost;dbname=clocker", 'clocker', '');
}

function close_database_connection(&$connection) {
    $connection = null;
}

function upload_task($userID, $taskName) {
    $connection = open_database_connection();

    $statement = $connection->prepare("INSERT INTO task (userID, nameTask, startTime, status) 
                                                VALUES (:userID, :taskName, NOW(), 'inprogress')");

    $statement->bindParam('userID', $userID, PDO::PARAM_INT);
    $statement->bindParam('taskName', $taskName);
    $statement->execute();

    close_database_connection($connection);
}
