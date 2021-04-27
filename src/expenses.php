<?php

namespace AccountingApp;

require_once __DIR__ . "/core/main.php";

$expenses = $db->fetchAll(<<<SQL
  SELECT *
  FROM Expense
SQL);

use AccountingApp\Template\Header;
use AccountingApp\Template\Footer; ?>
<?= Header\render(new Header\Props(title: "Home")) ?>

<h1>Expenses</h1>
<p>Accounts payable/bills go here!</p>

<table style="width: 50%;">
  <thead>
    <tr>
      <th>Name</th>
      <th>Period (days)</th>
      <th>Amount</th>
      <th>Comment</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody><?php
    foreach ($expenses as $expense) { ?>
      <tr>
        <td><a href="/expense.php?id=<?= $expense["id"] ?>"><?= escape_html($expense["name"]) ?></a></td>
        <td class="right"><?= number_format($expense["period"]) ?></td>
        <td class="right"><?= number_format($expense["amount"], 2) ?></td>
        <td class="right"><?= escape_html($expense["comment"]) ?></td>
        <td class="center" style="color: red;">
          <a class="plain" style="width: 100%; height: 100%; display: block;" onclick="return confirm('Are you sure you want to delete this Expense?');" href="/expense.php?id=<?= $expense["id"] ?>&delete=1">&cross;</a>
        </td>
      </tr><?php
    } ?>
  </tbody>
  <tfoot>
    <tr>
      <th class="right">Rows: <?= number_format(count($expenses)) ?></th>
      <th colspan="4"></th>
    </tr>
    <tr>
      <th colspan="5" class="right">
        <a href="/expense.php"><button>+ New</button></a>
      </th>
    </tr>
  </tfoot>
</table>

<?= Footer\render() ?>
