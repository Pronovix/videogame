<?php

// @codingStandardsIgnoreFile

use Drupal\Component\Utility\Crypt;

// Config.
$settings['install_profile'] = 'standard';
$config_folder = "{$app_root}/../config";
$config_directories['sync'] = $config_folder . '/sync';

// Hash salt.
$hash_salt_file = $config_folder . '/hash_salt.txt';
if (!file_exists($hash_salt_file)) {
  if (!file_exists(basename($hash_salt_file))) {
    if (!mkdir($config_folder, 0777, TRUE) && !is_dir($config_folder)) {
      throw new \RuntimeException(sprintf('Directory "%s" was not created', $config_folder));
    }
  }
  if (file_put_contents($hash_salt_file, Crypt::randomBytesBase64(55)) === FALSE) {
    throw new \RuntimeException(sprintf('File with hash_salt could not be saved to %s.', $hash_salt_file));
  }
}
$settings['hash_salt'] = file_get_contents($hash_salt_file);

// Updates.
$settings['update_free_access'] = FALSE;

// Entup.
$settings['entity_update_batch_size'] = 50;
$settings['entity_update_backup'] = TRUE;

// Files.
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];
$settings['file_private_path'] = DRUPAL_ROOT . '/../private';

// Server.
$settings['trusted_host_patterns'] = ['^webserver$', '^localhost$', '^.*\.itrainee\.pronovix\.net$'];

// DB.
$databases['default']['default'] = [];

// Services.
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

// Local settings.
if (file_exists(__DIR__ . '/settings.local.php')) {
  include __DIR__ . '/settings.local.php';
}
// Local services.
if (file_exists(__DIR__ . '/services.local.yml')) {
  $settings['container_yamls'][] = __DIR__ . '/services.local.yml';
}
