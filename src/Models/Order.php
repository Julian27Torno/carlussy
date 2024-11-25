<?php
namespace App\Models;

use PDO;

class OrderModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Create a new order
     *
     * @param string $customerName
     * @param string $customerEmail
     * @param int $menuItemId
     * @param int $quantity
     * @param float $totalPrice
     * @return bool
     */
    public function createOrder($customerName, $customerEmail, $menuItemId, $quantity, $totalPrice)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO Orders (customer_name, customer_email, menu_item_id, quantity, total_price) 
                VALUES (:customer_name, :customer_email, :menu_item_id, :quantity, :total_price)
            ");

            return $stmt->execute([
                ':customer_name' => $customerName,
                ':customer_email' => $customerEmail,
                ':menu_item_id' => $menuItemId,
                ':quantity' => $quantity,
                ':total_price' => $totalPrice
            ]);
        } catch (\PDOException $e) {
            die("Failed to create order: " . $e->getMessage());
        }
    }

    /**
     * Retrieve all orders
     *
     * @return array
     */
    public function getAllOrders()
    {
        try {
            $stmt = $this->pdo->query("SELECT o.*, m.name AS menu_item_name, m.price AS menu_item_price 
                                       FROM Orders o 
                                       JOIN Menu_Items m ON o.menu_item_id = m.id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Failed to fetch orders: " . $e->getMessage());
        }
    }

    /**
     * Retrieve an order by ID
     *
     * @param int $id
     * @return array|false
     */
    public function getOrderById($id)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT o.*, m.name AS menu_item_name, m.price AS menu_item_price 
                FROM Orders o 
                JOIN Menu_Items m ON o.menu_item_id = m.id
                WHERE o.id = :id
            ");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Failed to fetch order: " . $e->getMessage());
        }
    }

    /**
     * Delete an order by ID
     *
     * @param int $id
     * @return bool
     */
    public function deleteOrderById($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Orders WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            die("Failed to delete order: " . $e->getMessage());
        }
    }
}
