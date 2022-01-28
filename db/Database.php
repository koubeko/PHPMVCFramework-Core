<?php
/**
 * File Name: Database.php
 * @author Ondřej Koubek
 * Date: 26.01.2022
 * Time: 19:09
 */

namespace app\core\db;

use app\core\Application;
use PDO;
use PDOStatement;

/**
 * Class Database
 *
 * @author Ondřej Koubek
 * @namespace app\core
 */
class Database
{
    public PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations(): void
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log('All migrations are applied');
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS mvc_framework.migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations(): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM mvc_framework.migrations");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO mvc_framework.migrations (migration) VALUES
            $str
            ");
        $stmt->execute();
    }

    public function prepare(string $sql): bool|PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    protected function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}