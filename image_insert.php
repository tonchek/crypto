<?php
    include_once "session.php";
    adminOnly();
    include_once "database.php";
    
    $title = $_POST['title'];
    $id = (int) $_POST['id'];
    
    $target_dir = "images/";
    
    $random = date('YmdHisu');
    
    $target_file = $target_dir . $random . basename($_FILES["url"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    //preveri ali datoteka ima dejansko velikost
    $check = getimagesize($_FILES["url"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
      }
    
    
    // check file size max 5 MB
    if ($_FILES["url"]["size"] > 5000000) {
        $uploadOk = 0;
      }
    
    // allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        $uploadOk = 0;
      }
    
      
    // preverim, ali so podatki o sliki ustrezni
    if ($uploadOk == 1){
            if (move_uploaded_file($_FILES["url"]["tmp_name"], $target_file)) {
                // zapiše se vse v bazo
                $querry = "INSERT INTO images(title,url,cryptocurrency_id,user_id) VALUES(?,?,?,?)";
                $stmt = $pdo->prepare($querry);
                $stmt->execute([$title,$target_file,$id,$_SESSION['user_id']]);
    
                header("Location: cryptocurrency.php?id=$id");
                die();
            } else {
                header("Location: cryptocurrency.php?id=$id");
                die();
            }
    }
    else {
        header("Location: cryptocurrency.php?id=$id");
        die();
    }


?>