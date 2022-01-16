<?php

function open_database_connection() {
    // development local database
    return new PDO("mysql:host=localhost;dbname=clocker", 'clocker', '');
}

function close_database_connection(&$connection) {
    $connection = null;
}

function start_task($userID, $taskName) {
    $connection = open_database_connection();

    $statement = $connection->prepare("INSERT INTO task (userID, nameTask, startTime, status) 
                                                VALUES (:userID, :taskName, NOW(), 'inprogress')");

    $statement->bindParam('userID', $userID, PDO::PARAM_INT);
    $statement->bindParam('taskName', $taskName);
    $statement->execute();

    $addedTaskId = $connection->lastInsertId();

    $stmt = $connection->query("SELECT nameTask, startTime FROM task WHERE id=$addedTaskId");
    $result = $stmt->fetch();

    setcookie("activeTaskId", $addedTaskId);
    setcookie("activeTaskName", $result['nameTask']);
    setcookie("activeTaskStartTime", $result['startTime']);

    close_database_connection($connection);
}

function stop_task() {
    $connection = open_database_connection();

    $taskId = $_COOKIE['activeTaskId'];
    echo $taskId;
    // TODO: zmienić na ID konkretnego użytkownika, żeby nie móc zmienić statusu innemu użytkownikowi

    $statement = $connection->prepare("UPDATE task SET stopTime=NOW(), status='inactive' WHERE id=:taskId");
    $statement->bindParam('taskId', $taskId, PDO::PARAM_INT);
    $statement->execute();

    setcookie("activeTaskId", "", time() - 3600);
    setcookie("activeTaskName", "", time() - 3600);
    setcookie("activeTaskStartTime", "", time() - 3600);

    close_database_connection($connection);
}
