<?php

declare(strict_types=1);

namespace Kpaz\CreateWpPlugin\Service;

final class PluginScaffolder
{
    /**
     * @var list<string>
     */
    private const DIRECTORIES = [
        'assets',
        'assets/css',
        'assets/js',
        'assets/img',
        'inc',
        'templates',
        'languages',
        'src',
    ];

    public function directoryExists(string $name): bool
    {
        return is_dir($name);
    }

    public function create(string $name): void
    {
        mkdir($name);

        foreach (self::DIRECTORIES as $directory) {
            $path = sprintf('%s/%s', $name, $directory);

            mkdir($path, 0755, true);
            file_put_contents($path . '/index.php', "<?php\n// Silence is golden.\n");
        }

        file_put_contents($name . '/index.php', "<?php\n// Silence is golden.\n");
        file_put_contents($name . '/' . $name . '.php', $this->buildPluginHeader($name));
        file_put_contents($name . '/readme.txt', $this->buildReadme($name));
    }

    private function buildPluginHeader(string $name): string
    {
        return <<<PHP
<?php
/**
 * Plugin Name:       {$name}
 * Plugin URI:        https://example.com/
 * Description:       A brief description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Your Name
 * Author URI:        https://example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       {$name}
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

PHP;
    }

    private function buildReadme(string $name): string
    {
        return <<<TXT
=== {$name} ===
Contributors: (this should be a list of wordpress.org usernames)
Donate link: https://example.com/
Tags: (one, two)
Requires at least: 5.2
Tested up to: 6.0
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A brief description of the plugin.

== Description ==

A longer description of the plugin.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Changelog ==

= 1.0.0 =
* Initial release.
TXT;
    }
}
