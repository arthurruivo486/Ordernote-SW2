<?php
// productGroupController.php

// Verificação robusta dos arquivos necessários
$configPath = __DIR__ . '/../db/config.php';
$conexaoPath = __DIR__ . '/../db/conexao.php';
$modelPath = __DIR__ . '/../models/productGroupModel.php';

if (!file_exists($configPath)) {
    die("Erro: Arquivo config.php não encontrado em: " . $configPath);
}
if (!file_exists($conexaoPath)) {
    die("Erro: Arquivo conexao.php não encontrado em: " . $conexaoPath);
}
if (!file_exists($modelPath)) {
    die("Erro: Arquivo productGroupModel.php não encontrado em: " . $modelPath);
}

require_once $configPath;
require_once $conexaoPath;
require_once $modelPath;

class ProductGroupController {
    private $group;

    public function __construct() {
        try {
            $pdo = Conexao::getInstance();
            
            if (!Conexao::isConectado()) {
                throw new Exception("Não foi possível estabelecer conexão com o banco de dados.");
            }
            
            $this->group = new ProductGroupModel($pdo);
        } catch (Exception $e) {
            die("Erro no controlador: " . $e->getMessage());
        }
    }

    public function index() {
        try {
            $groups = $this->group->getAllGroups();
            $viewPath = __DIR__ . '/../views/groups/productGroupView.php';
            
            if (!file_exists($viewPath)) {
                throw new Exception("Arquivo de visualização não encontrado.");
            }
            
            include $viewPath;
        } catch (Exception $e) {
            die("Erro ao carregar a página: " . $e->getMessage());
        }
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->group->name = $_POST['name'] ?? '';
                $this->group->icon = $_POST['icon'] ?? '';
                
                if (empty($this->group->name)) {
                    throw new Exception("O nome do grupo é obrigatório.");
                }

                if ($this->group->addGroup()) {
                    header("Location: ../views/groups/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao criar grupo de produtos.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->group->id = $_POST['id'] ?? 0;
                $this->group->name = $_POST['name'] ?? '';
                $this->group->icon = $_POST['icon'] ?? '';
                
                if (empty($this->group->id) || empty($this->group->name)) {
                    throw new Exception("Dados inválidos para edição.");
                }

                if ($this->group->updateGroup()) {
                    header("Location: ../views/groups/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao alterar o grupo.");
                }
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        }
    }

    public function excluir() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->group->id = $_POST['id'] ?? 0;
                
                if (empty($this->group->id)) {
                    throw new Exception("ID inválido para exclusão.");
                }

                if ($this->group->deleteGroup()) {
                    header("Location: ../views/groups/index.php");
                    exit();
                } else {
                    throw new Exception("Erro ao excluir o grupo.");
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
            
            return $this->group->getGroupById($id);
        } catch (Exception $e) {
            die("Erro ao buscar grupo: " . $e->getMessage());
        }
    }
}

// Processamento das ações
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $controller = new ProductGroupController();
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
?>