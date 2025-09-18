<?php

// Verificação robusta dos arquivos necessários
$configPath = __DIR__ . '/../config/config.php';
$conexaoPath = __DIR__ . '/../config/conexao.php';
$modelPath   = __DIR__ . '/../models/productModel.php';
$groupModelPath = __DIR__ . '/../models/productGroupModel.php'; // Nova verificação

if (!file_exists($configPath)) {
    die("Erro: Arquivo config.php não encontrado em: " . $configPath);
}
if (!file_exists($conexaoPath)) {
    die("Erro: Arquivo conexao.php não encontrado em: " . $conexaoPath);
}
if (!file_exists($modelPath)) {
    die("Erro: Arquivo productModel.php não encontrado em: " . $modelPath);
}
if (!file_exists($groupModelPath)) {
    die("Erro: Arquivo productGroupModel.php não encontrado em: " . $groupModelPath);
}

require_once $configPath;
require_once $conexaoPath;
require_once $modelPath;
require_once $groupModelPath; // Nova inclusão

class ProductController {
    private $product;

    public function __construct() {
        try {
            $pdo = Conexao::getInstance();
            
            if (!Conexao::isConectado()) {
                throw new Exception("Não foi possível estabelecer conexão com o banco de dados.");
            }

            $this->product = new ProductModel($pdo);
        } catch (Exception $e) {
            die("Erro no controlador: " . $e->getMessage());
        }
    }

    // Adicione este método para buscar os grupos
    public function buscarGrupos() {
        try {
            $pdo = Conexao::getInstance();
            $groupModel = new ProductGroupModel($pdo);
            return $groupModel->getAllGroups();
        } catch (Exception $e) {
            die("Erro ao buscar grupos: " . $e->getMessage());
        }
    }

    // ... o restante dos métodos existentes (index, add, edit, excluir, buscarUm)
    
    public function index() {
        try {
            $products = $this->product->getAllProducts();
            $viewPath = __DIR__ . '/../views/products/productView.php';

            if (!file_exists($viewPath)) {
                throw new Exception("Arquivo de visualização não encontrado.");
            }

            include $viewPath;
        } catch (Exception $e) {
            die("Erro ao carregar produtos: " . $e->getMessage());
        }
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->product->group_id    = $_POST['group_id'] ?? null;
                $this->product->name        = $_POST['name'] ?? '';
                $this->product->description = $_POST['description'] ?? '';
                $this->product->image_url   = $_POST['image_url'] ?? '';
                $this->product->price       = $_POST['price'] ?? 0;
                $this->product->stock       = $_POST['stock'] ?? 0;
                $this->product->is_active   = $_POST['is_active'] ?? 1;

                if (empty($this->product->name)) {
                    throw new Exception("O nome do produto é obrigatório.");
                }

                if ($this->product->addProduct()) {
                    header("Location: ../views/products/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao cadastrar produto.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->product->id          = $_POST['id'] ?? 0;
                $this->product->group_id    = $_POST['group_id'] ?? null;
                $this->product->name        = $_POST['name'] ?? '';
                $this->product->description = $_POST['description'] ?? '';
                $this->product->image_url   = $_POST['image_url'] ?? '';
                $this->product->price       = $_POST['price'] ?? 0;
                $this->product->stock       = $_POST['stock'] ?? 0;
                $this->product->is_active   = $_POST['is_active'] ?? 1;

                if (empty($this->product->id) || empty($this->product->name)) {
                    throw new Exception("Dados inválidos para edição.");
                }

                if ($this->product->updateProduct()) {
                    header("Location: ../views/products/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao atualizar produto.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function excluir() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->product->id = $_POST['id'] ?? 0;

                if (empty($this->product->id)) {
                    throw new Exception("ID inválido para exclusão.");
                }

                if ($this->product->deleteProduct()) {
                    header("Location: ../views/products/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao excluir produto.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function buscarUm($id) {
        try {
            if (empty($id)) {
                throw new Exception("ID inválido.");
            }
            return $this->product->getProductById($id);
        } catch (Exception $e) {
            die("Erro ao buscar produto: " . $e->getMessage());
        }
    }
}

// Processamento das ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $controller = new ProductController();
        $acao = $_POST['acao'] ?? '';
        
        switch ($acao) {
            case 'incluir':
                $controller->add();
                break;
            case 'editar':
                $controller->edit();
                break;
            case 'excluir':
                $controller->excluir();
                break;
            default:
                throw new Exception("Ação inválida.");
        }
    } catch (Exception $e) {
        die("Erro no processamento: " . $e->getMessage());
    }
}