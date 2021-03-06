<?php

if (PHP_SAPI !== 'cli') {
  echo 'This script must be run from the command line.' . PHP_EOL;
  exit;
}

$root = find_root();
if (!$root) {
  echo 'ERROR: Drupal root not found. This command must be run from inside a Drupal installation.' . PHP_EOL;
  exit;
}

require __DIR__ . '/../src/JsonFile.php';
require __DIR__ . '/../composer_manager.module';

composer_manager_initialize($root);

echo 'Composer Manager has been successfuly initialized.' . PHP_EOL;

/**
 * Returns the absolute path to Drupal's root directory.
 */
function find_root() {
  $currentPath = __DIR__ . '/';
  $relativePath = '';
  $rootPath = '';
  $found = FALSE;
  while (!$found) {
    $rootPath =  $relativePath . $currentPath;
    echo $rootPath.';';
    if (is_dir($rootPath . 'vendor')) {
      $found = TRUE;
      break;
    }
    else {
      $relativePath .= '../';
      if (realpath($rootPath) === '/') {
        break;
      }
    }
  }
  var_dump($found,realpath($rootPath));
  return $found ? realpath($rootPath) : NULL;
}
