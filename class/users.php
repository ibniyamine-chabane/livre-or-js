<?php 

class users
{

    //attributs 
    private $database;
    private $id;    
    private $login;

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
        $emailOk = false;
    
        foreach ($userDatabase as $user) {
            
            if ( $this->login == $user['login']){
                echo "cette utilisateur existe déjà";
                $emailOk = false;
                break;
            } else {    
                $emailOk = true;
            }           
            echo $user['login']."<br>";
        }


        if ($emailOk == true){
        //on créer l'utilisateur.
          $request = $this->database->prepare("INSERT INTO user(login, password) VALUES (?, ?)");
          $request->execute(array($this->login, $password));
    
          echo "tu est inscrit";
        }        
          
        
    }

    public function connection($login, $password) {
        //session_start();

        $request = $this->database->prepare('SELECT `id` , `login` , `password` FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);

        $this->login = $login;
        $password;
        $logged = false;
                             

        foreach ($userDatabase as $user) { //je lis le contenu de la table de la BDD

            if ($login === $user['login'] && $password === $user['password']) {   
                $_SESSION['login'] = $login;
                $id = $user['id'];  
                $_SESSION['id_user'] = $id;
                $_SESSION["login"] = $user["login"];
                $logged = true;
                break;

            } else {
                $logged = false;
            }
        }


        if( $logged ) {
            echo "vous êtes connecté ".$_SESSION['firstname']." en tant que: ".$_SESSION['rights'];
            
            header('Location: index.php');
        } else {
            echo "erreur dans l'email ou le password</br>";
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

    public function updateProfil($email, $password) {

        $this->login = $email;
        $request = $this->database->prepare('SELECT * FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $emailOk = false;
        
        foreach ($userDatabase as $user) {
            
            if ($this->login == $_SESSION['login']) {
                $emailOk = true;
            } else if ( $this->login == $user['login']){
                $_SESSION['message_profil'] = "cette adresse appartient à un autre utilisateur";
                $emailOk = false;
                break;
            } else {
                $emailOk = true;
            }

        }

        if ($emailOk == true){
            
            $request = $this->database->prepare("UPDATE user SET `login` = (?) , `password` = (?) WHERE `user`.`id` = (?)");
            $request->execute(array($email, $password, $_SESSION['id_user']));
        
              //echo "votre profil a bien été modifier";
              $_SESSION['message_profil'] = "votre profil a bien été modifier";
            }               
    }

    public function changePassword($new_password) {

        $request = $this->database->prepare('SELECT * FROM user');
        $request->execute(array());
        $userDatabase = $request->fetchAll(PDO::FETCH_ASSOC);
        $request = $this->database->prepare("UPDATE user SET `password` = (?) WHERE `user`.`id` = (?)");
        $request->execute(array($new_password, $_SESSION['id']));

    }

}

//$user = new users;

// $user->register("maloo@.com","maloo","boubou");
// $user->register("elgato@churros.com","elgato","meowmeow");
// $user->register("yolo@fimo.com","yolo","stand");
// $user->connection("elmacho@dino.com","pocoloco");
// $user->connection("yolo@fimo.com","stand"); 
// $user->connection("admin@wild.com","azeradmin");
// echo $user->getAllUsers()['email'];
// echo $user->getAllUsers()['email'];
// echo $user->getAllUsers()['email'];

?>
