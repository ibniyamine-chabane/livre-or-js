<?php 

class users
{

    //attributs 
    private $database;
    private $id;    
    private $login;
    private $message;

    //Constructeur
    public function __construct(){ 
        try {
            $this->database = new PDO('mysql:host=localhost;dbname=livreorjs;charset=utf8;port=3307', 'root', '');

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    //Méthodes 

    public function register($login , $password) {

        $request = $this->database->prepare('SELECT * FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $this->login = $login;
        $password = password_hash($password, PASSWORD_DEFAULT);
        $emailOk = false;
    
        foreach ($userDatabase as $user) {
            
            if ( $this->login == $user['login']){
                $this->message = "cette utilisateur existe déjà";
                $emailOk = false;
                break;
            } else {    
                $emailOk = true;
            }           
        }


        if ($emailOk == true){
          $request = $this->database->prepare("INSERT INTO user(login, password) VALUES (?, ?)");
          $request->execute(array($this->login, $password));
          $this->message = "tu est inscrit";
        }        
          
        
    }

    public function connection($login, $password) {

        $request = $this->database->prepare('SELECT `id` , `login` , `password` FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $this->login = $login;
        $password;
        $logged = false;
                             
        // vérification dans la base de donnée
        foreach ($userDatabase as $user) { 

            if ($login === $user['login'] && password_verify($password, $user['password'])) {   
                $_SESSION['login'] = $login;
                $id = $user['id'];  
                $_SESSION['id_user'] = $id;
                $_SESSION["login"] = $user["login"];
                $logged = true;
                break;

            } else {
                $logged = false;
                $this->message = "erreur dans le login ou mot de passe";
            }
        }

        if( $logged ) {            
            header('Location: index.php');
        }

    }

    public function getData() {
        return $this->database;
    }

    public function getProfil() {

        $request = $this->database->prepare("SELECT * FROM user WHERE id = (?)");
        $request->execute(array($_SESSION['id_user']));
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        return $userDatabase;
    }

    public function updateLogin($login, $password) {

        $this->login = $login;
        $request = $this->database->prepare('SELECT * FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $emailOk = false;
        
        foreach ($userDatabase as $user) {
            
            if ($this->login == $_SESSION['login']) {
                $emailOk = true;
            } else if ( $this->login == $user['login']){
                $this->message = "cette adresse appartient à un autre utilisateur";
                $emailOk = false;
                break;
            } else {
                $emailOk = true;
            }

        }

        if ($emailOk == true){
            $request = $this->database->prepare("UPDATE user SET `login` = (?) , `password` = (?) WHERE `user`.`id` = (?)");
            $request->execute(array($login, $password, $_SESSION['id_user']));
            $_SESSION['login'] = $login;
            $this->message = "le login a été changé";
        }               
    }

    public function changePassword($new_password) {

        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $request = $this->database->prepare("UPDATE user SET `password` = (?) WHERE `user`.`id` = (?)");
        $request->execute(array($new_password, $_SESSION['id_user']));

    }

    public function getMessage() {
        return $this->message;
    }

}


?>
