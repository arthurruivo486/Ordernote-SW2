<?php 
class ProductGroupModel {
    private $pdo;
    public $id;
    public $name;
    public $icon;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->id = 0;
        $this->name = '';
        $this->icon = '';
    }

    public function getAllGroups() {
        $stmt = $this->pdo->prepare("SELECT * FROM product_groups");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGroupById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM product_groups WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addGroup() {
        $stmt = $this->pdo->prepare("INSERT INTO product_groups (name, icon) VALUES (?, ?)");
        $stmt->execute([$this->name, $this->icon]);
        return $this->pdo->lastInsertId();
    }

    public function updateGroup() {
        $stmt = $this->pdo->prepare("UPDATE product_groups SET name = ?, icon = ? WHERE id = ?");
        return $stmt->execute([$this->name, $this->icon, $this->id]);
    }

    public function deleteGroup() {
        $stmt = $this->pdo->prepare("DELETE FROM product_groups WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
?>