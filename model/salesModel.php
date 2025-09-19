<?php 
class SalesModel{

    private $pdo;
    public $id;
    public $order_id;
    public $customer_id;
    public $user_id;
    public $total_amount;
    public $payment_method;
    public $status;

    public function __construct($pdo){
      $this->pdo = $pdo;
      $this->id = 0;
      $this->order_id = 0;
      $this->customer_id = 0;
      $this->user_id = 0;
      $this->total_amount = 0.00;
      $this->payment_method = '';
      $this->status = '';
    }

    public function getAllSales(){
      $stmt = $this->pdo->prepare("SELECT * FROM sales");
      $stmt->execute();
      return ;
    }

    public function getSalesById($id){
      $stmt = $this->pdo->prepare("SELECT * FROM sales WHERE id = ?");
      $stmt->execute([$id]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSales(){
      $stmt = $this->pdo->prepare("INSERT INTO sales (order_id,	customer_id,	user_id,	total_amount, payment_method,	status) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->execute([$this->order_id, $this->customer_id, $this->user_id, $this->total_amount, $this->payment_method, $this->status]);
      return $this->pdo->lastInsertId();
    }

    public function updateSales(){
      $stmt = $this->pdo->prepare("UPDATE sales SET order_id = ?,	customer_id = ?,	user_id= ?,	total_amount = ?, payment_method = ?,	status = ?");
      return $stmt->execute([$this->order_id, $this->customer_id, $this->user_id, $this->total_amount, $this->payment_method, $this->status, $this->id]);
    }

    public function deleteSales(){
      $stmt = $this->pdo->prepare("DELETE FROM sales WHERE id = ?");
      return $stmt->execute([$this->id]);
    }

}
?>