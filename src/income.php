<?php

namespace AccountingApp;

require_once __DIR__ . "/core/main.php";

$income = $db->fetchOne(<<<SQL
  SELECT *
  FROM Income
  WHERE id = ?
SQL, [$_GET["id"] ?? 0]);

if ($_GET["delete"] ?? 0 == "1") {
  $db->run(<<<SQL
    DELETE FROM Income
    WHERE id = ?
  SQL, [
    $_GET["id"],
  ]);
  header("Location: /incomes.php#deleted");
  die;
}

if (!empty($_POST)) {
  if (empty($_POST["name"]) || empty($_POST["period"]) || empty($_POST["amount"])) {
    http_response_code(400);
    die("400 Bad Request");
  }

  if ($_GET["id"] ?? false) {
    $db->run(<<<SQL
      UPDATE Income
      SET `name`    = ?,
          `period`  = ?,
          `amount`  = ?,
          `comment` = ?
      WHERE id = ?
    SQL, [
      $_POST["name"],
      $_POST["period"],
      $_POST["amount"],
      $_POST["comment"] ?? "",
      $_GET["id"],
    ]);
    header("Location: /income.php?id=$_GET[id]");
    die;
  } else {
    $db->run(<<<SQL
      INSERT INTO Income
      SET `name`    = ?,
          `period`  = ?,
          `amount`  = ?,
          `comment` = ?
    SQL, [
      $_POST["name"],
      $_POST["period"],
      $_POST["amount"],
      $_POST["comment"] ?? "",
    ]);
    $id = $db->lastInsertId();
    header("Location: /income.php?id=$id");
    die;
  }
}

use AccountingApp\Template\Header;
use AccountingApp\Template\Footer; ?>
<?= Header\render(new Header\Props(title: "Home")) ?>


<style>
  form.edit .edit-text {
    display: none;
  }

  form.edit .edit-input {
    display: initial;
  }

  form:not(.edit) .edit-text {
    display: initial;
  }

  form:not(.edit) .edit-input {
    display: none;
  }
</style>

<a href="/incomes.php"><button>&lt;&lt; Incomes</button></a>

<form method="post" class="<?= $income ? "" : "edit" ?>">
  <fieldset style="width: 50%;">
    <legend>Income Details</legend>
    <dl>
      <dt>Name</dt>
      <dd>
        <span class="edit-text"><?= escape_html($income["name"] ?? "") ?></span>
        <input class="edit-input" type="text" size="50" name="name" value="<?= escape_html($income["name"] ?? "") ?>" required>
      </dd>

      <dt>Period (days)</dt>
      <dd>
        <span class="edit-text"><?= number_format($income["period"] ?? 1) ?></span>
        <input class="edit-input" type="number" min="1" max="65535" name="period" value="<?= $income["period"] ?? 1 ?>" required>
      </dd>

      <dt>Amount</dt>
      <dd>
        <span class="edit-text">$<?= number_format($income["amount"] ?? 0, 2) ?></span>
        <input class="edit-input" type="number" min="0.01" max="65535" name="amount" step="0.01" value="<?= $income["amount"] ?? 0 ?>" required>
      </dd>

      <dt>Comment</dt>
      <dd>
        <span class="edit-text"><?= escape_html($income["comment"] ?? "") ?></span>
        <input class="edit-input" type="text" size="100" name="comment" value="<?= escape_html($income["comment"] ?? "") ?>">
      </dd>
    </dl>
    <button type="button" class="edit-text" onclick="document.querySelector('form').classList.toggle('edit');">Edit</button>
    <a class="plain" href="?id=<?= $_GET['id'] ?? 0 ?>&delete=1" onclick="return confirm('Are you sure you want to delete this Income?');"><button type="button" class="edit-text">Delete</button></a>
    <button type="submit" class="edit-input">Save</button>
    <button type="reset" class="edit-input" onclick="document.querySelector('form').classList.toggle('edit');">Cancel</button>
  </fieldset>
</form>

<?= Footer\render() ?>
