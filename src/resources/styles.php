<?php

namespace AccountingApp;

require_once __DIR__ . "/../core/main.php";
require_once __DIR__ . "/../vendor/scssphp/scss.inc.php";

// TODO(low): support and cache source maps

function compile_less(string $filename): array {
  global $redis;

  $filepath = realpath(__DIR__ . "/less/$filename");
  assert(file_exists($filepath));
  $mtime = filemtime($filepath);

  if ($redis->hGet(MRA_REDIS_KEY::STYLE_CACHE_MTIME_HASHSET, $filename) == $mtime) {
    $css = $redis->hGet(MRA_REDIS_KEY::STYLE_CACHE_CSS_HASHSET, $filename);
  } else {
    $scss = new \ScssPhp\ScssPhp\Compiler();
    $css = $scss->compileString(file_get_contents($filepath))->getCss();
    $redis->hSet(MRA_REDIS_KEY::STYLE_CACHE_MTIME_HASHSET, $filename, $mtime);
    $redis->hSet(MRA_REDIS_KEY::STYLE_CACHE_CSS_HASHSET, $filename, $css);
  }

  return [ $mtime, $css ];
}

[ $mtime, $css ] = compile_less("style.scss");
header("Content-Type: text/css");
header("ETag: $mtime");

die($css);
