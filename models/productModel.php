<?php 
class ProductModel {
    private $pdo;
    public $id;
    public $group_id;
    public $name;
    public $description;
    public $image_url;
    public $price;
    public $stock;
    public $is_active;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->id = 0;
        $this->group_id = 0;
        $this->name = '';
        $this->description = '';
        $this->image_url = '';
        $this->price = 0.00;
        $this->stock = 0;
        $this->is_active = 1;
    }

    public function getAllProducts() {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct() {
        $stmt = $this->pdo->prepare("INSERT INTO products (group_id, name, description, image_url, price, stock, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$this->group_id, $this->name, $this->description, $this->image_url, $this->price, $this->stock, $this->is_active]);
        return $this->pdo->lastInsertId();
    }

    public function updateProduct() {
        $stmt = $this->pdo->prepare("UPDATE products SET group_id = ?, name = ?, description = ?, image_url = ?, price = ?, stock = ?, is_active = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$this->group_id, $this->name, $this->description, $this->image_url, $this->price, $this->stock, $this->is_active, $this->id]);
    }

    public function deleteProduct() {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
?>
