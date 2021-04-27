<?php

namespace AccountingApp;

require_once __DIR__ . "/core/main.php";

$result = $db->fetchOne(<<<SQL
  SELECT
    (SELECT SUM(Expense.`amount` / Expense.`period`)  FROM Expense) AS `expense_daily`,
    (SELECT SUM(Income.`amount` / Income.`period`)    FROM Income)  AS `income_daily`
SQL);

use AccountingApp\Template\Header;
use AccountingApp\Template\Footer; ?>
<?= Header\render(new Header\Props(title: "Home")) ?>

<fieldset style="width: 20%; display: inline-block; margin: 0 1rem;">
  <legend>Expenses</legend>

  <dl>
    <dt>Daily</dt>
    <dd>$<?= number_format($result["expense_daily"], 2) ?></dd>

    <dt>Weekly</dt>
    <dd>$<?= number_format($result["expense_daily"] * 7, 2) ?></dd>


    <dt>Monthly (30-day)</dt>
    <dd>$<?= number_format($result["expense_daily"] * 30, 2) ?></dd>

    <dt>Annual (365-day)</dt>
    <dd>$<?= number_format($result["expense_daily"] * 365, 2) ?></dd>
  </dl>
</fieldset>


<fieldset style="width: 20%; display: inline-block; margin: 0 1rem;">
  <legend>Income</legend>

  <dl>
    <dt>Daily</dt>
    <dd>$<?= number_format($result["income_daily"], 2) ?></dd>

    <dt>Weekly</dt>
    <dd>$<?= number_format($result["income_daily"] * 7, 2) ?></dd>


    <dt>Monthly (30-day)</dt>
    <dd>$<?= number_format($result["income_daily"] * 30, 2) ?></dd>

    <dt>Annual (365-day)</dt>
    <dd>$<?= number_format($result["income_daily"] * 365, 2) ?></dd>
  </dl>
</fieldset>

<fieldset style="width: 20%; display: inline-block; margin: 0 1rem;">
  <legend>Remainders</legend>

  <dl>
    <dt>Daily</dt>
    <dd>$<?= number_format($result["income_daily"] - $result["expense_daily"], 2) ?></dd>

    <dt>Weekly</dt>
    <dd>$<?= number_format(($result["income_daily"] - $result["expense_daily"]) * 7,  2) ?></dd>


    <dt>Monthly (30-day)</dt>
    <dd>$<?= number_format(($result["income_daily"] - $result["expense_daily"]) * 30, 2) ?></dd>

    <dt>Annual (365-day)</dt>
    <dd>$<?= number_format(($result["income_daily"] - $result["expense_daily"]) * 365, 2) ?></dd>
  </dl>
</fieldset>


<?= Footer\render() ?>
