<?php
class User{
    private $pdo;

    public function __construct() {
        try {
           $this->pdo = new PDO("mysql:host=localhost;dbname=ordernote-db", "root", "");
           $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
           die("Erro de conexão: " . $e->getMessage()); 
        }
    }

    public function login($email, $senha) {
      $sql = "SELECT * FROM user WHERE email = :email AND status = 'active' LIMIT 1";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(":email", $email);
      $stmt->execute();

        if ($stmt->rowCount() > 0) {
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

           if (password_verify($senha, $user['password_hash'])) {
             return $user;
           }
         }
          return false;
      }
    public function createUser($name, $email, $senha){
      $check = $this->pdo->prepare("SELECT id FROM user WHERE email = :email LIMIT 1");   
      $check->bindValue(":email", $email);  
      $check->execute();  
      
      if ($check->rowCount() > 0){
         return false;
      }

      $hash = password_hash($senha, PASSWORD_DEFAULT);

      $sql = "INSERT INTO user (name, email, password_hash, status, role) 
            VALUES (:name, :email, :password_hash, 'active', 'user')";

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(":name", $name);
      $stmt->bindValue(":email", $email);
      $stmt->bindValue(":password_hash", $hash);

      return $stmt->execute();
    }
   }
?>