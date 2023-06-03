<?php
session_start();
require_once("class/users.php");
if (empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
    header("Location:index.php");
    exit;
}

$user = new users; 
$userDb = $user->getProfil()[0];
$prefilled_login = $userDb["login"];
$current_password = $userDb["password"];

if (isset($_POST['submit'])) 
{
    if ($_POST['login'] && $_POST['current_password']) 
    {
        if ($_POST['current_password'] == $current_password) 
        {

            $login = htmlspecialchars(trim($_POST['login']));
            $password =  htmlspecialchars(trim($_POST['current_password']));
            $user->updateProfil($login, $password);

        } else {
            echo "les mot de passe ne correspond pas";
        }    

    } else {
        echo "veuillez remplir tout les champs";
    } 

    if ($_POST['current_password'] && $_POST['new_password'] && $_POST['password_confirm']) 
    {
        
        if($_POST['current_password'] == $current_password && $_POST['new_password'] == $_POST['password_confirm'] ) {

            $new_password = $_POST['new_password'];
            $user->changePassword($new_password);
            echo "le mot de passe a été modifier";

        } else if ($_POST['current_password'] != $current_password) {
            echo "erreur";
        } else if ($_POST['new_password'] != $_POST['password_confirm']) {
            echo "les nouveau mdp et la confirmation ne sont pas identique";
        }
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
    <title>Profil</title>
</head>
<body>
    <?php include("header.php"); ?>
    <main>
        <section>
            <?php if (isset($_SESSION['message_profil'])) :?>
                <span style="text-align: center;display: block;color: green;font-weight: bold;background-color: #ffffffa3;width: 30%;margin: auto;"><?= $_SESSION['message_profil'] ?></span>
                <?php endif; ?>
                <div class="container-form">
                <h2>Profil</h2>
                    <form action="" method="post">
                        <label for="login">email</label>
                        <input type="login" name="login" value="<?= $prefilled_login ?>" >
                        <label for="current_password">mot de passe actuelle (valider votre mdp si vous voulez seulement modifier les infos ci dessus)</label><!-- mot de passe actuel -->
                        <input type="password" name="current_password">
                        <label for="new_password">nouveau mot de passe</label><!-- nouveau mot de passe -->
                        <input type="password" name="new_password">
                        <label for="password_confirm">confirmer mot de passe</label><!-- confirmer le nouveu mdp -->
                        <input type="password" name="password_confirm">
                        <input type="submit" name="submit" value="valider" class="button">
                    </form>
                </div>    
        </section> 
    </main>
    <?php include("footer.php"); ?>
</body>
</html>