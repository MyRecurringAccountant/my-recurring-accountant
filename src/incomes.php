<?php

namespace AccountingApp;

require_once __DIR__ . "/core/main.php";

$incomes = $db->fetchAll(<<<SQL
  SELECT *
  FROM Income
SQL);

use AccountingApp\Template\Header;
use AccountingApp\Template\Footer; ?>
<?= Header\render(new Header\Props(title: "Home")) ?>

<h1>Income</h1>
<p>Accounts receivable/payroll go here!</p>

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
    foreach ($incomes as $income) { ?>
      <tr>
        <td><a href="/income.php?id=<?= $income["id"] ?>"><?= escape_html($income["name"]) ?></a></td>
        <td class="right"><?= number_format($income["period"]) ?></td>
        <td class="right"><?= number_format($income["amount"], 2) ?></td>
        <td class="right"><?= escape_html($income["comment"]) ?></td>
        <td class="center" style="color: red;">
          <a class="plain" style="width: 100%; height: 100%; display: block;" onclick="return confirm('Are you sure you want to delete this Income?');" href="/income.php?id=<?= $income["id"] ?>&delete=1">&cross;</a>
        </td>
      </tr><?php
    } ?>
  </tbody>
  <tfoot>
    <tr>
      <th class="right">Rows: <?= number_format(count($incomes)) ?></th>
      <th></th>
      <th class="right">$<?= number_format(array_sum(array_column($incomes, "amount")), 2) ?></th>
      <th></th>
      <th></th>
    </tr>
    <tr>
      <th colspan="5" class="right">
        <a href="/income.php"><button>+ New</button></a>
      </th>
    </tr>
  </tfoot>
</table>

<?= Footer\render() ?>
