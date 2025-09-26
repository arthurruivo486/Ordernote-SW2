<?php
class SalesModel
{

  private $pdo;
  public $id;
  public $order_id;
  public $customer_id;
  public $user_id;
  public $total_amount;
  public $payment_method;
  public $status;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
    $this->id = 0;
    $this->order_id = 0;
    $this->customer_id = 0;
    $this->user_id = 0;
    $this->total_amount = 0.00;
    $this->payment_method = '';
    $this->status = '';
  }

  public function buscarPorId($id)
  {
    $sql = "SELECT sales.*, customers.name AS customer_name, products.name AS product_name
                FROM sales
                INNER JOIN customers ON customers.id = sales.customer_id
                INNER JOIN products ON products.id = sales.product_id
                WHERE sales.id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAllSales()
  {
    try {
      $sql = "SELECT 
        s.id AS sale_id,
        c.name AS customer_name,
        s.total_amount,
        s.payment_method,
        s.status,
        s.created_at
        FROM sales s
        JOIN customers c ON s.customer_id = c.id
        ORDER BY s.id DESC;";
      $stmt = $this->pdo->query($sql);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      throw new Exception("Erro ao buscar vendas: " . $e->getMessage());
    }
  }

public function listar() {
    try {
        $sql = "
            SELECT 
                s.id, 
                c.name AS customer_name, 
                s.created_at,
                GROUP_CONCAT(CONCAT(p.name, ' (', si.quantity, ')') SEPARATOR ', ') AS products,
                SUM(si.quantity * si.unit_price) AS total_amount
            FROM sales s
            INNER JOIN customers c ON c.id = s.customer_id
            LEFT JOIN sale_items si ON si.sale_id = s.id
            LEFT JOIN products p ON p.id = si.product_id
            GROUP BY s.id, c.name, s.created_at
            ORDER BY s.created_at DESC
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        die("Erro ao listar vendas: " . $e->getMessage());
    }
}



  public function getSaleById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM sales WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function create($customer_id, $items) {
    // Verifica se cliente existe
    $stmt = $this->pdo->prepare("SELECT id FROM customers WHERE id = :id");
    $stmt->execute(['id' => $customer_id]);
    if (!$stmt->fetch()) {
        throw new Exception("Cliente não existe.");
    }

    // Cria a venda
    $stmt = $this->pdo->prepare("INSERT INTO sales (customer_id, created_at) VALUES (:customer_id, NOW())");
    $stmt->execute(['customer_id' => $customer_id]);
    $saleId = $this->pdo->lastInsertId();

    // Insere itens
    foreach ($items as $item) {
        $stmt = $this->pdo->prepare("
            INSERT INTO sales_items (sale_id, product_id, quantity, price)
            VALUES (:sale_id, :product_id, :quantity, :price)
        ");
        $stmt->execute([
            'sale_id'    => $saleId,
            'product_id' => $item['product_id'],
            'quantity'   => $item['quantity'],
            'price'      => $item['price'],
        ]);
    }

    return $saleId;
}


  public function addSale()
  {
    $stmt = $this->pdo->prepare("INSERT INTO sales (order_id,	customer_id,	user_id,	total_amount, payment_method,	status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$this->order_id, $this->customer_id, $this->user_id, $this->total_amount, $this->payment_method, $this->status]);
    return $this->pdo->lastInsertId();
  }

  public function updateSale()
  {
    $stmt = $this->pdo->prepare("UPDATE sales SET order_id = ?,	customer_id = ?,	user_id= ?,	total_amount = ?, payment_method = ?,	status = ?");
    return $stmt->execute([$this->order_id, $this->customer_id, $this->user_id, $this->total_amount, $this->payment_method, $this->status, $this->id]);
  }

  public function deleteSale()
  {
    $stmt = $this->pdo->prepare("DELETE FROM sales WHERE id = ?");
    return $stmt->execute([$this->id]);
  }
}
