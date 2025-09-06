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
        $sql = "SELECT * FROM users WHERE email = :email AND status = 'active' LIMIT 1";
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
   }
?>