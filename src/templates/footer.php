<?php

namespace AccountingApp\Template\Footer;

use function AccountingApp\trim_indents;

require_once __DIR__ . "/../core/main.php";

final class Props {}

function render(?Props $props = null)
{
  if (!$props) $props = new Props();
  ob_start(); ?>
    </main>
  </body>
  </html><?php
  return trim_indents(ob_get_clean());
};
