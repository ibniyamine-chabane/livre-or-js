<?php
session_start();
if (!empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
    header("Location:index.php");
    exit;
}

$message = ""; // variable d'affichage de message d'erreur à déclarer pour éviter un message  d'erreur
require_once("class/users.php");
$user = new users;

if (isset($_POST['submit'])) {

    if ($_POST['login'] && $_POST['password'] && $_POST['password_confirm']) {
     
        if ($_POST['password'] == $_POST['password_confirm']) {

            $login = htmlspecialchars(trim($_POST['login']));
            $password =  htmlspecialchars(trim($_POST['password']));
            $user->register($login, $password);

        }else {
            $message = "les mot de passe ne correspond pas";
        }    

    } else {
        $message = "veuillez remplir tout les champs"; 
    } 
} 
        
        

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widthfr, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
    <?php include("header.php"); ?>
    <main>
        <section>
            <div class="container-form">
                <h1>Inscription</h1>
                <p class="msg-error"><?= $message ?></p>
                <form method="post">
                    <label for="flogin">Login</label>
                    <input type="text" name="login" placeholder="Choisissez votre login">
                    <label for="fpassword">Mot de Passe</label>
                    <input type="password" name="password" placeholder="Mot de Passe">
                    <input type="password" name="password_confirm" placeholder="Confirmer le mot de Passe">
                    <input type="submit" name="submit" value="valider">
                </form>
            </div>
        </section> 
    </main>
    <?php include("footer.php"); ?> 
</body>
</html>