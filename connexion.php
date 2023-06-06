<?php 

session_start();
if (!empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
    header("Location:index.php");
    exit;
}

$message = "";

require_once("class/users.php");
$user = new users;

if (isset($_POST['submit'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];
    if($login && $password ) {
    $user->connection($login, $password);
    $message = $user->getMessage();
    } else {
        $message = "veuillez remplir tous les champs";
    }
}
 
?>  
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>
    <?php  include("header.php");  ?>
    <main style="height:100vh">
        <div class="container-form space-bottom-connect">
            <h1>Connexion</h1>
            <p class="msg-error"><?= $message ?></p>
            <form method="post">
                <label for="flogin">Login</label>
                <input type="text" name="login" placeholder="login">
                <label for="fpassword">Mot de Passe</label>
                <input type="password" name="password" placeholder="Mot de Passe">
                <input type="submit" name="submit" value="Se Connecter">
            </form>
        </div>
    </main>
    <?php include("footer.php"); ?>
</body>
</html>