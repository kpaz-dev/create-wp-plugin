<?php

declare(strict_types=1);

namespace Kpaz\CreateWpPlugin;

use Kpaz\CreateWpPlugin\Command\NewPluginCommand;
use Kpaz\CreateWpPlugin\Service\PluginScaffolder;
use Symfony\Component\Console\Application;

final class CliApplicationFactory
{
    public static function create(): Application
    {
        $application = new Application('WP Plugin CLI', '1.0.0');
        $application->add(new NewPluginCommand(new PluginScaffolder()));

        return $application;
    }
}
