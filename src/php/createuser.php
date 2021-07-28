<?php

$username = 'bali';

include_once("./connect.php");

$sql = "INSERT INTO players(username) VALUES (?)";
$stmt = $database->stmt_init();

$stmt->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

?>