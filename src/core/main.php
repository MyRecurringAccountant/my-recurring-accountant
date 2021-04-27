<?php

namespace AccountingApp;

session_start();

function trim_indents(string $str): string
{
  $lines = explode("\n", $str);
  $indent_level = strlen($lines[0]) - strlen(ltrim($lines[0]));

  $indent_chars = substr($lines[0], 0, $indent_level);

  return implode("\n", array_map(
    fn ($line) => str_starts_with($line, $indent_chars) ? substr($line, $indent_level) : $line,
    $lines,
  ));
}

function escape_html($str = ""): string {
  return trim(htmlspecialchars(strval($str), ENT_COMPAT | ENT_QUOTES | ENT_SUBSTITUTE));
}

final class Logger
{
  public static final function log(string $message): void
  {
    file_put_contents("php://stderr", "[AccountingApp] $message\n");
  }
}

final class MRA_REDIS_KEY
{
  const DATABASE_MIGRATE_FLAG     = "MRA:database:migration_performed";
  const STYLE_CACHE_MTIME_HASHSET = "MRA:style_cache:mtime";
  const STYLE_CACHE_CSS_HASHSET   = "MRA:style_cache:css";
}

$redis = new \Redis();
$redis->connect("redis");

require_once __DIR__ . "/database.php";
$db = Database::getInstance();

// Load templates
require_once __DIR__ . "/../templates/footer.php";
require_once __DIR__ . "/../templates/header.php";
