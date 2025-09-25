<?php
class customersModel {
    private $customers = [];

    public function __construct() {
        // Dados iniciais, pode ser substituído por banco de dados
        $this->customers = [
            "João Silva",
            "Maria Oliveira",
            "Carlos Pereira"
        ];
    }

    public function getAll() {
        return $this->customers;
    }

    public function add($customerName) {
        $this->customers[] = $customerName;
    }
}
?>
