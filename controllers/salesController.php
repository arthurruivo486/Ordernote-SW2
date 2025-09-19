<?php

// Verificação robusta dos arquivos necessários
$configPath = __DIR__ . '/../config/config.php';
$conexaoPath = __DIR__ . '/../config/conexao.php';
$modelPath   = __DIR__ . '/../models/salesModel.php';
$groupModelPath = __DIR__ . '/../models/salesGroupModel.php'; // Nova verificação

if (!file_exists($configPath)) {
    die("Erro: Arquivo config.php não encontrado em: " . $configPath);
}
if (!file_exists($conexaoPath)) {
    die("Erro: Arquivo conexao.php não encontrado em: " . $conexaoPath);
}
if (!file_exists($modelPath)) {
    die("Erro: Arquivo salesModel.php não encontrado em: " . $modelPath);
}
if (!file_exists($groupModelPath)) {
    die("Erro: Arquivo salesGroupModel.php não encontrado em: " . $groupModelPath);
}

require_once $configPath;
require_once $conexaoPath;
require_once $modelPath;
require_once $groupModelPath; // Nova inclusão

class SalesController {
    private $sales;

    public function __construct() {
        try {
            $pdo = Conexao::getInstance();
            
            if (!Conexao::isConectado()) {
                throw new Exception("Não foi possível estabelecer conexão com o banco de dados.");
            }

            $this->sales = new SalesModel($pdo);
        } catch (Exception $e) {
            die("Erro no controlador: " . $e->getMessage());
        }
    }

    // ... o restante dos métodos existentes (index, add, edit, excluir, buscarUm)
    
    public function index() {
        try {
            $sales = $this->sales->getAllSales();
            $viewPath = __DIR__ . '/../views/sales/salesView.php';

            if (!file_exists($viewPath)) {
                throw new Exception("Arquivo de visualização não encontrado.");
            }

            include $viewPath;
        } catch (Exception $e) {
            die("Erro ao carregar compras: " . $e->getMessage());
        }
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->sales->order_id = $_POST['order_id'] ?? null;
                $this->sales->customer_id = $_POST['customer_id'] ?? null;
                $this->sales->user_id = $_POST['user_id'] ?? null;
                $this->sales->total_amount = $_POST['total_amount'] ?? 0;
                $this->sales->payment_method = $_POST['payment_method'] ?? '';
                $this->sales->status = $_POST['status'] ?? '';

                if (empty($this->sales->addSales)) {
                    throw new Exception("O nome da compra é obrigatório.");
                }

                if ($this->sales->addSales()) {
                    header("Location: ../views/sales/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao cadastrar a compra.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->sales->id = $_POST['id'] ?? 0;
                $this->sales->order_id = $_POST['order_id'] ?? null;
                $this->sales->customer_id = $_POST['customer_id'] ?? null;
                $this->sales->user_id = $_POST['user_id'] ?? null;
                $this->sales->total_amount = $_POST['total_amount'] ?? 0;
                $this->sales->payment_method = $_POST['payment_method'] ?? '';
                $this->sales->status = $_POST['status'] ?? '';

                if (empty($this->sales->id) || empty($this->sales->name)) {
                    throw new Exception("Dados inválidos para edição.");
                }

                if ($this->sales->updateSales()) {
                    header("Location: ../views/sales/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao atualizar compra.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function excluir() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->sales->id = $_POST['id'] ?? 0;

                if (empty($this->sales->id)) {
                    throw new Exception("ID inválido para exclusão.");
                }

                if ($this->sales->deleteSales()) {
                    header("Location: ../views/sales/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao excluir compra.");
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
            return $this->sales->getSalesById($id);
        } catch (Exception $e) {
            die("Erro ao buscar compra: " . $e->getMessage());
        }
    }
}

// Processamento das ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $controller = new SalesController();
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