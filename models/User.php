class User{
    private $conn;
    private $table = 'users';

    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }
}

public function login($email, $senha){
    $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($senha, $user['senha'])){
            return $user;
        }
    }
    return false;
}