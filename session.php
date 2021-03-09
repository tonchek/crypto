<?php
session_start();

//do katere strani ima neprijavljeni uporabnik dostop
$allow = ['/crypto/login.php','/crypto/register.php','/crypto/index.php','/crypto/login_check.php'];

//preverim ali je uporabnik prijavljen, če ni ga peljem na prijavo
if  (!isset($_SESSION['user_id']) && (!in_array($_SERVER['REQUEST_URI'],$allow))){
    
    header("Location: login.php");
    die();
}

function getFullName($user_id) {
    require "database.php";

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);

    $user = $stmt->fetch();

    return $user['first_name'].' '.$user['last_name'];
}

//vrača za trenutno prijavljenega uporabnika
function admin() {
    return $_SESSION['admin'];
}

//če trenutno prijavljeni ni admin, ga preusmeri na index
function adminOnly() {
    if (!isset($_SESSION['admin']) || ($_SESSION['admin'] != 1)){
    header("Location: index.php");
    die();
    }
}

function odziv ($message) {
    //session_start();
    $_SESSION['odziv'] = $message;
}

?>