<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $driver;
    
    public $conn;

    public function __construct() {
        $this->driver = getenv('DB_DRIVER') ?: 'mysql';
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->port = getenv('DB_PORT') ?: ($this->driver === 'pgsql' ? '5432' : '3306');
        $this->db_name = getenv('DB_NAME') ?: 'gudang_fashion';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            if ($this->driver === 'pgsql') {
                // PostgreSQL Connection
                $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . 
                       ";dbname=" . $this->db_name;
            } else {
                // MySQL Connection
                $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . 
                       ";dbname=" . $this->db_name;
            }
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $exception) {
            echo "Database Connection Error: " . $exception->getMessage();
            exit();
        }

        return $this->conn;
    }
}
?>