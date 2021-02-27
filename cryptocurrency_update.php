<?php
include_once "session.php";
include_once "database.php";

$id = $_POST['id']; //katero valuto urejam

$title = $_POST['title'];
$description = $_POST['description'];
$current_price = floatval($_POST['current_price']);


$target_dir = "uploads/";

$random = date('Ymdhisu');

$target_file = $target_dir . $random . basename($_FILES["logo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//preveri ali datoteka ima dejansko velikost
$check = getimagesize($_FILES["logo"]["tmp_name"]);
if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }


// check file size max 5 MB
if ($_FILES["logo"]["size"] > 5000000) {
    $uploadOk = 0;
  }

// allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    $uploadOk = 0;
  }

  
// preverim, ali so podatki polni in ustrezni
if (!empty($title)){

    if ($uploadOK == 1)
        //uporabnik je ob urejanju naložil nov logo
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            // zapiše se vse v bazo
            $querry = "UPDATE cryptocurrencies SET title=?, description=?, current_price=?, logo=? WHERE id=?";
            $stmt = $pdo->prepare($querry);
            $stmt->execute([$title,$description,$current_price,$target_file,$id]);

            header("Location: cryptocurrency.php?id=".$id);
            die();

        } else {
            header("Location: cryptocurrency.edit?id=".$id);
            die();
        }
    else {
        //uporabnik ni naložil logo
        $querry = "UPDATE cryptocurrencies SET title=?, description=?, current_price=? WHERE id=?";
            $stmt = $pdo->prepare($querry);
            $stmt->execute([$title,$description,$current_price,$id]);

            header("Location: cryptocurrency.php?id=".$id);
            die();
    }
    
}
else {
    header("Location: cryptocurrency_add.php");
    die();
}


?>