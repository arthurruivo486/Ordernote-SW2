class loginController {
    public function index() {
        require __DIR__ . '/../views/login.php';
    }
    public function autenticar(){
        if($result){
           session_start();
           $_SESSION['usuario'] = $result['email'];
           header("Location: /app/views/home.php");
           exit;
        } else {
           echo "E-mail ou senha inválidos";
        }
    }
}
