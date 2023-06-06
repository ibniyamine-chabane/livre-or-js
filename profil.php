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
$message = "" ;

if (isset($_POST['submit'])) 
{
    if ($_POST['login'] && $_POST['current_password']) 
    {
        if (password_verify($_POST['current_password'], $current_password)) 
        {

            $login = htmlspecialchars(trim($_POST['login']));
            $password =  htmlspecialchars(trim($_POST['current_password']));
            $user->updateLogin($login, $password);
            $message = $user->getMessage(); 
        } else {
            $message = "les mot de passe ne correspond pas";
        }    

    } else {
        $message = "veuillez remplir tout les champs";
    } 

    if ($_POST['current_password'] && $_POST['new_password'] && $_POST['password_confirm']) 
    {
        
        if(password_verify($_POST['current_password'], $current_password) && $_POST['new_password'] == $_POST['password_confirm'] ) {

            $new_password = $_POST['new_password'];
            $user->changePassword($new_password);
            $message = "le mot de passe a été modifier";

        } else {
            $message = "erreur";
        }
        
        if ($_POST['new_password'] != $_POST['password_confirm']) {
            $message = "les nouveau mdp et la confirmation ne sont pas identique";
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
            <?php if (isset($message)) :?>
                <span style="text-align: center;display: block;color: green;font-weight: bold;background-color: #ffffffa3;width: 30%;margin: auto;"><?= $message ?></span>
                <?php endif; ?>
                <div class="container-form">
                <h2>Profil</h2>
                    <form action="" method="post">
                        <label for="login">login</label>
                        <input type="login" name="login" value="<?= $prefilled_login ?>" >
                        <label for="current_password">mot de passe actuelle</label><!-- mot de passe actuel -->
                        <input type="password" name="current_password" placeholder="mot de passe à valider pour toute modification">
                        <label for="new_password">nouveau mot de passe</label><!-- nouveau mot de passe -->
                        <input type="password" name="new_password" placeholder="votre nouveau mot de passe">
                        <label for="password_confirm">confirmer mot de passe</label><!-- confirmer le nouveu mdp -->
                        <input type="password" name="password_confirm" placeholder="confirmer votre mot de passe">
                        <input type="submit" name="submit" value="modifier" class="button">
                    </form>
                </div>    
        </section> 
    </main>
    <?php include("footer.php"); ?>
</body>
</html>