<?php

declare(strict_types=1);

namespace Kpaz\CreateWpPlugin\Command;

use Kpaz\CreateWpPlugin\Service\PluginScaffolder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class NewPluginCommand extends Command
{
    protected static $defaultName = 'new';

    public function __construct(private readonly PluginScaffolder $pluginScaffolder)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new WordPress plugin scaffold')
            ->addArgument('name', InputArgument::REQUIRED, 'Plugin slug (directory and main file name)')
            ->addOption('docker', null, InputOption::VALUE_NONE, 'Generate a local Docker setup with WordPress, DB and WP-CLI');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $name */
        $name = (string) $input->getArgument('name');
        $withDocker = (bool) $input->getOption('docker');

        if ($this->pluginScaffolder->directoryExists($name)) {
            $output->writeln('<error>Directory already exists.</error>');
            return Command::FAILURE;
        }

        $this->pluginScaffolder->create($name, $withDocker);
        $output->writeln('<info>Plugin created successfully!</info>');

        if ($withDocker) {
            $output->writeln('<comment>Docker environment generated (docker-compose.yml + .env.example).</comment>');
        }

        return Command::SUCCESS;
    }
}
