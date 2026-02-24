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
        mkdir($name . '/src');

        $pluginFile = "$name/$name.php";

        file_put_contents(
            $pluginFile,
            "<?php\n\n/**\n * Plugin Name: $name\n */\n"
        );

        $output->writeln("<info>Plugin created successfully!</info>");

        return Command::SUCCESS;
    }

}