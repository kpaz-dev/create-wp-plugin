<?php

namespace Kpaz\CreateWpPlugin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewPluginCommand extends Command
{
    protected static $defaultName = 'new';

    public function __construct()
    {
        parent::__construct('new');
    }

    protected function configure(): void
    {
        $this->setDescription('Create a new WP plugin')
        ->addArgument('name', InputArgument::REQUIRED, 'Plugin name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        if(is_dir($name)) {
            $output->writeln("<error>Directory already exists</error>");
            return Command::FAILURE;
        }

        mkdir($name);

        $directories = [
            'assets',
            'assets/css',
            'assets/js',
            'assets/img',
            'inc',
            'templates',
            'languages',
            'src'
        ];

        foreach ($directories as $dir) {
            mkdir($name . '/' . $dir, 0755, true);
            file_put_contents($name . '/' . $dir . '/index.php', "<?php\n// Silence is golden.\n");
        }

        file_put_contents($name . '/index.php', "<?php\n// Silence is golden.\n");

        $pluginFile = "$name/$name.php";

        $pluginHeader = <<<PHP
<?php
/**
 * Plugin Name:       $name
 * Plugin URI:        https://example.com/
 * Description:       A brief description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Your Name
 * Author URI:        https://example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       $name
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

PHP;

        file_put_contents($pluginFile, $pluginHeader);

        $readmeContent = <<<TXT
=== $name ===
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

        file_put_contents("$name/readme.txt", $readmeContent);

        $output->writeln("<info>Plugin created successfully!</info>");

        return Command::SUCCESS;
    }

}