<?php

$configPath     = __DIR__ . '/../config/config.php';
$conexaoPath    = __DIR__ . '/../config/conexao.php';
$salesModelPath = __DIR__ . '/../models/salesModel.php';

if (!file_exists($configPath)) {
    die("Erro: Arquivo config.php não encontrado em: " . $configPath);
}
if (!file_exists($conexaoPath)) {
    die("Erro: Arquivo conexao.php não encontrado em: " . $conexaoPath);
}
if (!file_exists($salesModelPath)) {
    die("Erro: Arquivo salesModel.php não encontrado em: " . $salesModelPath);
}

require_once $configPath;
require_once $conexaoPath;
require_once $salesModelPath;

class SalesController
{
    private $sales;
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = Conexao::getInstance();

            if (!Conexao::isConectado()) {
                throw new Exception("Não foi possível estabelecer conexão com o banco de dados.");
            }

            $this->sales = new SalesModel($this->pdo);
        } catch (Exception $e) {
            die("Erro no controlador: " . $e->getMessage());
        }
    }

    public function index()
    {
        try {
            $sales = $this->sales->getAllSales();
            $viewPath = __DIR__ . '/../views/sales/salesView.php';

            if (!file_exists($viewPath)) {
                throw new Exception("Arquivo de visualização não encontrado.");
            }

            include $viewPath;
        } catch (Exception $e) {
            die("Erro ao carregar vendas: " . $e->getMessage());
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->sales->order_id = $_POST['order_id'] ?? null;
                $this->sales->customer_id = $_POST['customer_id'] ?? null;
                $this->sales->user_id = $_POST['user_id'] ?? null;
                $this->sales->total_amount = $_POST['total_amount'] ?? 0;
                $this->sales->payment_method = $_POST['payment_method'] ?? '';
                $this->sales->status = $_POST['status'] ?? '';

                if ($this->sales->addSale()) {
                    header("Location: ../views/sales/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao cadastrar a venda.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function listar()
    {
        try {
            $dados = $this->sales->getAllSales();
            return $dados ?: [];
        } catch (Exception $e) {
            die("Erro ao listar vendas: " . $e->getMessage());
        }
    }

    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->sales->id = $_POST['id'] ?? 0;
                $this->sales->order_id = $_POST['order_id'] ?? null;
                $this->sales->customer_id = $_POST['customer_id'] ?? null;
                $this->sales->user_id = $_POST['user_id'] ?? null;
                $this->sales->total_amount = $_POST['total_amount'] ?? 0;
                $this->sales->payment_method = $_POST['payment_method'] ?? '';
                $this->sales->status = $_POST['status'] ?? '';

                if (empty($this->sales->id)) {
                    throw new Exception("ID inválido para edição.");
                }
                if ($this->sales->updateSale()) {
                    header("Location: ../views/sales/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao atualizar venda.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function excluir()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->sales->id = $_POST['id'] ?? 0;

                if (empty($this->sales->id)) {
                    throw new Exception("ID inválido para exclusão.");
                }

                if ($this->sales->deleteSale()) {
                    header("Location: ../views/sales/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao excluir venda.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function buscarUm($id)
    {
        try {
            if (empty($id)) {
                throw new Exception("ID inválido.");
            }
            return $this->sales->getSaleById($id);
        } catch (Exception $e) {
            die("Erro ao buscar venda: " . $e->getMessage());
        }
    }

    public function buscarPorId($id)
    {
        if (empty($id)) {
            throw new Exception("ID inválido");
        }
        return $this->sales->buscarPorId($id);
    }

    public function buscarClientes()
    {
        try {
            $sql = "SELECT id, name FROM customers ORDER BY name ASC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Erro ao buscar clientes: " . $e->getMessage());
        }
    }

    public function buscarProdutos()
    {
        try {
            $sql = "SELECT id, name, price FROM products ORDER BY name ASC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Erro ao buscar produtos: " . $e->getMessage());
        }
    }
}

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
