<?php
include_once "header.php";
?>

<h1>Kripto valute</h1>

<a href="cryptocurrency_add.php" class="btn btn-primary btn-xl">Dodaj valuto</a>
<br />

<?php
    include_once "database.php";
    $query = "SELECT * FROM cryptocurrencies";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    while ($row = $stmt->fetch()){
        echo $row['title'].' - '.$row['current_price'];
        echo '<br />';
    }


?>

<?php
include_once "footer.php";
?>