<?php

declare(strict_types=1);

namespace Kpaz\CreateWpPlugin\Command;

use Kpaz\CreateWpPlugin\Service\PluginScaffolder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
            ->addArgument('name', InputArgument::REQUIRED, 'Plugin slug (directory and main file name)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $name */
        $name = (string) $input->getArgument('name');

        if ($this->pluginScaffolder->directoryExists($name)) {
            $output->writeln('<error>Directory already exists.</error>');
            return Command::FAILURE;
        }

        $this->pluginScaffolder->create($name);
        $output->writeln('<info>Plugin created successfully!</info>');

        return Command::SUCCESS;
    }
}
