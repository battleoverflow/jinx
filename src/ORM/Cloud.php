<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx\ORM;

use Jinx\Jinx;

class Cloud {
    public \PDO $pdo_handler;

    public function __construct(array $db_config = []) {
        // Extract database configuration info from the db_config array
        $db_dsn = $db_config['db_dsn'] ?? "";
        $db_username = $db_config['db_username'] ?? "";
        $db_password = $db_config['db_password'] ?? "";

        $this->connect($db_dsn, $db_username, $db_password);
    }

    public function connect($db_dsn, $db_username, $db_password) {
        // Initialize a new database connection with the provided data
        $this->pdo_handler = new \PDO($db_dsn, $db_username, $db_password);

        // Throw an exception if something is wrong with the db PDO config
        $this->pdo_handler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function execute($statement) {
        $this->pdo_handler->exec($statement);
    }

    public function prepare($statement) {
        return $this->pdo_handler->prepare($statement);
    }

    /* Migrations */

    public function creatMigrationsTable() {
        /*
            Create the migrations table in the database using SQL syntax
        */
        
        // Create a migrations table if it doesn't already exist
        $create_table = "
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ";

        $this->execute($create_table);
    }

    public function applyMigrations() {
        /*
            Applies migrations
        */

        $this->creatMigrationsTable();

        // Init log
        $logger = Jinx::$jinx->logger;

        // Handles the initial migration file
        $applied_migrations = $this->getCompletedMigrations();

        $new_migrations = [];

        // Locates all migration files in the 'migrations' directory
        $files = scandir(Jinx::$ROOT_DIR."/migrations");

        // Compares arrays to check for more migration files
        $apply_migrations = array_diff($files, $applied_migrations);

        // Iterates over all migration files
        foreach ($apply_migrations as $migration) {
            if ($migration == "." || $migration == "..") {
                continue;
            }

            require_once Jinx::$ROOT_DIR."/migrations/".$migration;
            
            $logger->jinxLog("Applying migration $migration", "terminal");
            $sql_query = Jinx::$jinx->db->prepare(file_get_contents(Jinx::$ROOT_DIR."/migrations/".$migration));
            $sql_query->execute();
            
            $logger->jinxLog("Applied migration $migration", "terminal");
            $new_migrations[] = $migration;
        }

        // Applies migration if the migration is new
        if (!empty($new_migrations)) {
            $this->insertMigrations($new_migrations);
        } else {
            $logger->jinxLog("All migrations are already applied", "terminal");
        }
    }

    public function getCompletedMigrations() {
        /*
            Collect all migrations currently present in the database
        */

        $fetch_migrations = $this->prepare("SELECT migration FROM migrations");
        $fetch_migrations->execute();

        // Fetch all values within the migrations column as an array
        return $fetch_migrations->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function insertMigrations(array $migrations) {
        /*
            Insert missing migrations into the database
        */

        // Creates an array list seperate by commas
        // Example: ("file_0.php"), ("file_1.php")
        $migrations_arr = implode(",", array_map(fn($m) => "('$m')", $migrations));

        $insert_migrations = $this->prepare("INSERT INTO migrations (migration) VALUES $migrations_arr");
        $insert_migrations->execute();
    }
}

?>
