<?php

class comments 
{
    private $database;

    public function __construct(){ 
        try {
            $this->database = new PDO('mysql:host=localhost;dbname=livreorjs;charset=utf8;port=3307', 'root', '');

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function writeComment($comment, ) {

        $request = $this->database->prepare("INSERT INTO commentaires(commentaire,id_user,date) VALUES ((?), (?), NOW())");
        $request->execute(array($comment, $_SESSION['id_user']));
        header("Location:livre-or.php");
    }

    public function displayComments() {
        $request = $this->database->prepare('SELECT `date` , `login` , `commentaire` FROM user INNER JOIN commentaires ON user.id = commentaires.id_user ORDER BY `date` DESC ');
        $request->execute();
        return $data = $request->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>