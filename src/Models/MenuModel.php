<?
namespace App\Models;

use PDO;

class MenuModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllMenuItems()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM Menu_Items");
            $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!$menuItems) {
                die("No menu items found or query failed.");
            }
    
            return $menuItems;
        } catch (PDOException $e) {
            die("Database query failed: " . $e->getMessage());
        }
    }
}