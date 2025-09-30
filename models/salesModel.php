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

  public function createSale($customerId, $userId, $products)
{
    $pdo = $this->db;

    // 1. Cria venda inicial
    $stmt = $pdo->prepare("INSERT INTO sales (customer_id, user_id, created_at, total_amount) VALUES (?, ?, NOW(), 0)");
    $stmt->execute([$customerId, $userId]);
    $saleId = $pdo->lastInsertId();

    $total = 0;

    // 2. Percorre produtos
    foreach ($products as $productId => $data) {
        if (!isset($data['selected'])) continue;

        $quantity = (int)$data['quantity'];

        // pega produto
        $stmt = $pdo->prepare("SELECT price, stock FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();

        if (!$product || $product['stock'] < $quantity) continue;

        $unitPrice = $product['price'];
        $subtotal = $unitPrice * $quantity;
        $total += $subtotal;

        // insere em sale_items
        $stmt = $pdo->prepare("INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$saleId, $productId, $quantity, $unitPrice, $subtotal]);

        // atualiza estoque
        $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$quantity, $productId]);
    }

    // 3. Atualiza total da venda
    $stmt = $pdo->prepare("UPDATE sales SET total_amount = ? WHERE id = ?");
    $stmt->execute([$total, $saleId]);

    return $saleId;
}

  
  public function buscarItensVenda($saleId) {
    try {
        $stmt = $this->pdo->prepare("
            SELECT 
                si.product_id,
                si.quantity,
                si.unit_price,
                si.subtotal,
                p.name AS product_name
            FROM sale_items si
            JOIN products p ON p.id = si.product_id
            WHERE si.sale_id = ?
        ");
        $stmt->execute([$saleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao buscar itens da venda: " . $e->getMessage();
        return [];
    }
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
                s.id AS sale_id,
                s.customer_id,
                c.name AS customer_name,
                s.total_amount,
                s.created_at
            FROM sales s
            JOIN customers c ON c.id = s.customer_id
            ORDER BY s.created_at DESC
        ";
        $stmt = $this->pdo->query($sql); // Executa a query
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
    try {
        $stmt = $this->pdo->prepare("INSERT INTO sales (customer_id, total) VALUES (?, 0)");
        $stmt->execute([$customer_id]);
        $saleId = $this->pdo->lastInsertId();

        $total = 0;

        foreach ($items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            $stmtProduct = $this->pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmtProduct->execute([$product_id]);
            $product = $stmtProduct->fetch();

            if (!$product) continue;

            $unit_price = $product['price'];
            $subtotal = $unit_price * $quantity;
            $total += $subtotal;

            $stmtItem = $this->pdo->prepare(
                "INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, subtotal) 
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmtItem->execute([$saleId, $product_id, $quantity, $unit_price, $subtotal]);
        }

        $stmtUpdate = $this->pdo->prepare("UPDATE sales SET total = ? WHERE id = ?");
        $stmtUpdate->execute([$total, $saleId]);

        return $saleId;

    } catch (PDOException $e) {
        echo "Erro ao registrar venda: " . $e->getMessage();
        return false;
    }
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
