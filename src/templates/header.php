<?php

namespace AccountingApp\Template\Header;

use function AccountingApp\trim_indents;

require_once __DIR__ . "/../core/main.php";

final class Props
{
  private ?string $title;

  public function __construct(?string $title = null)
  {
    $this->setTitle($title);
  }

  public function getTitle(): string
  {
    return $this->title ? "{$this->title} | AccountingApp" : "AccountingApp";
  }

  public function setTitle(?string $title): static
  {
    $this->title = $title;
    return $this;
  }
}

function render(?Props $props = null)
{
  if (!$props) $props = new Props();
  ob_start(); ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $props->getTitle() ?></title>
    <link rel="stylesheet" href="/resources/styles.php" type="text/css">
  </head>

  <body>
    <header>
      <a href="/" class="brand">AccountingApp</a>
      <nav>
        <ul>
          <li><a href="/incomes.php"  <?= $_SERVER["SCRIPT_NAME"] == "/incomes.php"  ? 'class="current"' : "" ?>>Income</a></li>
          <li><a href="/expenses.php" <?= $_SERVER["SCRIPT_NAME"] == "/expenses.php" ? 'class="current"' : "" ?>>Expenses</a></li>
          <li><a href="/report.php"   <?= $_SERVER["SCRIPT_NAME"] == "/report.php"   ? 'class="current"' : "" ?>>Report</a></li>
        </ul>
      </nav>
    </header>
    <main><?php
  return trim_indents(ob_get_clean());
};
