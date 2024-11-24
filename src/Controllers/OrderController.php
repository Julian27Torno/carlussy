<?php
namespace App\Controllers;

use App\Models\MenuModel;
use PDO;
use Dotenv\Dotenv;

class OrderController extends BaseController
{
    private $menuModel;
    private $pdo;

    public function __construct()
    {
        // Load .env variables from the config folder (adjust path if needed)
        $dotenv = Dotenv::createImmutable(__DIR__ . '.env'); // Path to your .env file
        $dotenv->load();

        // Get database connection details from the .env file
        $dbHost = $_ENV['DB_HOST'] ?? '127.0.0.1'; // Fallback to '127.0.0.1' if not set in .env
        $dbPort = $_ENV['DB_PORT'] ?? '3306'; // Default to '3306' if not set
        $dbName = $_ENV['DB_DATABASE'] ?? 'finals'; // Default to 'finals' if not set
        $dbUsername = $_ENV['DB_USERNAME'] ?? 'root'; // Default to 'root' if not set
        $dbPassword = $_ENV['DB_PASSWORD'] ?? ''; // Default to empty if not set

        try {
            // Initialize PDO using .env values
            $this->pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUsername, $dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Initialize the MenuModel with the PDO instance
            $this->menuModel = new MenuModel($this->pdo);
        } catch (PDOException $e) {
            // Handle error (optional: log it)
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function index()
    {
        // Fetch all menu items from the MenuModel
        $menuItems = $this->menuModel->getAllMenuItems();

        // Pass the menu items to the view and render it
        return $this->render('order', ['menuItems' => $menuItems]);
    }

    public function submitOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle order submission
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $item = $_POST['item'] ?? '';
            
            // Simulate success
            $success = "Order submitted successfully!";
            
            // Fetch all menu items again for the view
            $menuItems = $this->menuModel->getAllMenuItems();
            
            // Render view with success message
            return $this->render('order', ['success' => $success, 'menuItems' => $menuItems]);
        }

        // Redirect to order page if not POST
        header('Location: /order');
        exit;
    }
}
