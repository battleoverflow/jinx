<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\Database;

use Jinx\Application;

class DatabaseManager
{
    public \PDO $pdo_handler;

    public function __construct(array $db_config = [])
    {
        // Extract database configuration info from the db_config array
        $db_dsn = $db_config['db_dsn'] ?? '';
        $db_username = $db_config['db_username'] ?? '';
        $db_password = $db_config['db_password'] ?? '';

        $this->connect($db_dsn, $db_username, $db_password);
    }

    public function connect($db_dsn, $db_username, $db_password)
    {
        // Initialize a new database connection with the provided data
        $this->pdo_handler = new \PDO($db_dsn, $db_username, $db_password);

        // Throw an exception if something is wrong with the db PDO config
        $this->pdo_handler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function execute($statement)
    {
        $this->pdo_handler->exec($statement);
    }

    public function prepare($statement)
    {
        return $this->pdo_handler->prepare($statement);
    }

    /* Migrations */

    public function creatMigrationsTable()
    {
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

    public function applyMigrations()
    {
        /*
            Applies migrations
        */

        $this->creatMigrationsTable();

        // Init log
        $log = Application::$jinx->log;

        // Handles the initial migration file
        $applied_migrations = $this->getCompletedMigrations();

        $new_migrations = [];

        // Locates all migration files in the 'migrations' directory
        $files = scandir(Application::$ROOT_DIR.'/migrations');

        // Compares arrays to check for more migration files
        $apply_migrations = array_diff($files, $applied_migrations);

        // Iterates over all migration files
        foreach ($apply_migrations as $migration) {
            if ($migration == '.' || $migration == '..') {
                continue;
            }

            require_once Application::$ROOT_DIR.'/migrations/'.$migration;

            // Collects filename without the extension
            $filename = pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $filename();
            
            $log->log("Applying migration $migration", "terminal");
            $instance->up();
            
            $log->log("Applied migration $migration", "terminal");
            $new_migrations[] = $migration;
        }

        // Applies migration if the migration is new
        if (!empty($new_migrations)) {
            $this->insertMigrations($new_migrations);
        } else {
            $log->log("All migrations are complete", "terminal");
        }
    }

    public function getCompletedMigrations()
    {
        /*
            Collect all migrations currently present in the database
        */

        $fetch_migrations = $this->prepare("SELECT migration FROM migrations");
        $fetch_migrations->execute();

        // Fetch all values within the migrations column as an array
        return $fetch_migrations->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function insertMigrations(array $migrations)
    {
        /*
            Insert missing migrations into the database
        */

        // Creates an array list seperate by commas
        // Example: ('file_0.php'), ('file_1.php')
        $migrations_arr = implode(",", array_map(fn($m) => "('$m')", $migrations));

        $insert_migrations = $this->prepare("INSERT INTO migrations (migration) VALUES $migrations_arr");
        $insert_migrations->execute();
    }
}

?>
