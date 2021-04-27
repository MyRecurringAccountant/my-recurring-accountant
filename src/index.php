<?php

namespace AccountingApp;

require_once __DIR__ . "/core/main.php";

use AccountingApp\Template\Header;
use AccountingApp\Template\Footer; ?>
<?= Header\render(new Header\Props(title: "Home")) ?>

<h1>Personal Finance Manager</h1>

<article>
  <p>Welcome to the Personal Finance Manager website.</p>
  <p>This website is to help people with money management and paying bills.</p>

  <p>
    The user will put in any bills they have, along with how much the bills cost to pay, and how often they have to pay it,
    and they will have to put in how many paychecks they get, with how much money they get, and how often they get them.
  </p>

  <p>
    After that, the program will calculate how much they have to spend in total,
    how much they have to save each week, and how much money they will have after saving money each week.
  </p>

  <p>
    Click the Start button on the screen to start using the Personal Finance Manager, or use the navigation tabs
    located at the top of the page.
  </p>

  <a href="/income.php"><button>Start</button></a>
</article>

<?= Footer\render() ?>
