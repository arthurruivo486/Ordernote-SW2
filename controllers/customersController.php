<?php
require_once __DIR__ . '/../models/customersModel.php';
require_once __DIR__ . '/../views/customersView.php';

class customercontroller {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new CustomersModel();
        $this->view = new CustomersView();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['customerName'])) {
            $this->model->add(trim($_POST['customerName']));
        }
        
        $customers = $this->model->getAll();
        $this->view->render($customers);
    }
}
?>

