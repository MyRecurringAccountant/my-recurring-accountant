<?php

namespace AccountingApp;

require_once __DIR__ . "/main.php";

class Database
{
  /**
   * The stored singleton instance.
   */
  private static ?Database $instance;

  /**
   * Gets (and sets, if needed) the singleton instance.
   */
  public static function getInstance(): Database
  {
    if (empty(Database::$instance))
      Database::$instance = new Database();
    return Database::$instance;
  }

  /**
   * The PDO instance for the MySQL connection.
   */
  private \PDO $conn;

  private function __construct()
  {
    $this->conn = new \PDO("mysql:host=mysql;port=3306;dbname=accounting_app", "root", getenv("MYSQL_ROOT_PASSWORD"), [
      \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    ]);

    $time = $this->fetchOne("SELECT NOW() AS `now`", column: "now");
    assert(is_string($time));
    Logger::log("Connected to database at $time");

    $this->migrate();
  }

  /**
   * Runs all add migrations.
   */
  private function migrateAdd(): void
  {
    $add_files = array_filter(scandir(__DIR__ . "/migrate/add"), fn ($x) => $x != "." && $x != "..");
    foreach ($add_files as $file) {
      $sql = file_get_contents(realpath(__DIR__ . "/migrate/add/$file"));
      Logger::log("Executing ADD migration file: $file");
      $this->conn->exec($sql);
    }
  }

  /**
   * Runs all drop migrations.
   */
  private function migrateDrop(): void
  {
    $drop_files = array_filter(scandir(__DIR__ . "/migrate/drop"), fn ($x) => $x != "." && $x != "..");
    foreach ($drop_files as $file) {
      $sql = file_get_contents(realpath(__DIR__ . "/migrate/drop/$file"));
      Logger::log("Executing DROP migration file: $file");
      $this->conn->exec($sql);
    }
  }

  private function migrate(): void
  {
    global $redis;
    if ($redis->get(MRA_REDIS_KEY::DATABASE_MIGRATE_FLAG) !== "1") {
      $this->migrateDrop();
      $this->migrateAdd();
      $redis->set(MRA_REDIS_KEY::DATABASE_MIGRATE_FLAG, "1");
      Logger::log("MRA migration complete; stored flag in redis.");
    }
  }

  public function run(string $sql, array $params = []): \PDOStatement
  {
    $this->conn->beginTransaction();
    $statement = $this->conn->prepare($sql);
    Logger::log("RUN SQL: $sql");
    try {
      $statement->execute($params);
      $this->conn->commit();
    } catch (\Throwable $e) {
      $this->conn->rollBack();
      throw $e;
    }
    return $statement;
  }

  public function fetchOne(string $sql, array $params = [], ?string $column = null): array|string|null
  {
    $row = $this->run($sql, $params)->fetch();
    if ($row == null)
      return null;
    return $column ? $row[$column] : $row;
  }

  public function fetchAll(string $sql, array $params = [], ?string $column = null, bool $unique = false): array
  {
    $result = $this->run($sql, $params)->fetchAll();
    if ($unique)
      $result = array_unique($result, SORT_REGULAR);
    return $column ? array_column($result, $column) : $result;
  }

  public function lastInsertId(): int {
    // return $this->conn->lastInsertId();
    return $this->fetchOne("SELECT LAST_INSERT_ID() AS id", column: "id");
  }
}
