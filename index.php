<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //definir la variable courante a la variable initiale
        $img_name = $_FILES['img']['name'];
        //definir et aassocier le chemin de la variable courabte a la variable initiale
        $tmp_name = $_FILES['img']['tmp_name'];
        //definir et associer la taille du fichier de la variable courabte a la variable initiale
        $img_size = $_FILES['img']['size'];
        //definir une variable erreur afin de traiter le comportement des erreur et leur attributions
        $error = $_FILES['img']['error'];
        require("./connect/connexion.php");

        if($error === 0) {
            //fixer une taille maximal au fichier
            if($img_size > 150000) {
                $msg_err = "DESOLE LA TAILLE DE L'IMAGES TROP GRANDE !";
                header("location: index.php?error=".$msg_err);
            }else {
                //definir a l'aide de pathinfo_extension les extention des fichier qui serons accepter par l'application
                $img_extention = pathinfo($img_name, PATHINFO_EXTENSION);
                //convertion en miniscule de l'extention
                $img_extention_convert = strtolower($img_extention);
                //definir les extention autoriser
                $allowed_extentions = array("jpeg", "jpg", "png");
                //
                if(in_array($img_extention_convert, $allowed_extentions)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_extention_convert;
                    $img_upload_path = 'files/' . $new_img_name;
                    //envoi du fichier dans le dossier preparer
                    move_uploaded_file($tmp_name, $img_upload_path);
                    //envoi de l'url de l'image dans la base de donnée
                    $req = $db->prepare("INSERT INTO files(name) VALUES(:new_img_name)");
                    $req->bindParam(':new_img_name', $new_img_name);
                    $req->execute();
                }else {
                $msg_err = "VOUS NE POUVEZ SOUMETTE UN FICHIER DE CE TYPE !";
                header("location:index.php?error=".$msg_err);
                }
            }
        }else {
        $msg_err = "UNE ERROR EST SURVENUE LORS DE LA L'ENVOI !";
        header("location: index.php?error=" . $msg_err);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <title>UPLOAD FILES</title>
</head>
<body>

    <form method="post" enctype="multipart/form-data">
        <label for="img">FILES</label>
        <input type="file" name="img" id="img">
        <input type="submit" value="Envoyer">
    </form>
    
</body>
</html>