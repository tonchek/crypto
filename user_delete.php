<?php
include_once "session.php";
adminOnly();
include_once "database.php";

$id = (int) $_GET['id'];

//izbriše vse njegove komantarje
$query = "DELETE FROM comments WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);

//ohranim vse slike
$query = "UPDATE images SET user_id=NULL WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);

//ohranim vse ocene
$query = "UPDATE rates SET user_id=NULL WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);

$query = "DELETE FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);

header("Location: users.php");
die();

?>