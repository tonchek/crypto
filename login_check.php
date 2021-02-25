<?php
session_start();
include_once "database.php";

$email = $_POST['email'];
$pass = $_POST['pass'];

if (!empty($email) && !empty($pass)){
    $querry = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($querry);
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(); // $user[first_name], $user[last_name], $user[email], $user[id]

        if (password_verify($pass, $user['pass'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['admin'] = $user['admin'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            header("Location: index.php");
            die();
        }
    }

}
header("Location: login.php");
die();
?>