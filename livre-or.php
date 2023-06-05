<?php 
session_start();

require_once("class/comments.php");

$displayComments = new comments;
$data = $displayComments->displayComments();
// var_dump($data);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>livre d'or</title>
</head>
<body>
<?php include("header.php");?>
    <main>
        <section>
        <h1 class="golden_book_title">Livre d'or</h1>
        <?php if (empty($_SESSION['login'])): ?>
            <p style="font-family: system-ui;
                      text-align: center;
                      color: gold;
                      padding-bottom: 8px;
                      font-size: 22px;">connecter vous pour laisser un commentaire</p>    
        <?php endif; ?>
            <?php foreach ($data as $info) {
                $dateold = $info["date"];
                $date = date('d-m-Y H:i:s', strtotime($dateold));
                $pseudo = $info['login']; 
                $comment = $info['commentaire'];   
                
                echo '<div class="comment_box">
                        <div class="user_info_box">
                            <img src="import/profil-vide.png" class="profil_picture" alt="image de profil">
                            <div>
                                <h3>'.$pseudo.'</h3>
                                <p>posté le '.$date.' </p>
                            </div>
                        </div>
                        <div class="comment_display">
                            <p>'.$comment.'</p>
                        </div>
                      </div>';      
            }
            ?>
            
            

        </section>    
    </main>
</body>
</html>