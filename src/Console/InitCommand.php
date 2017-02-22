<?php

namespace Sanuj\Diplomat\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class InitCommand extends SymfonyCommand
{
    use Command;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Create a new Diplomat file in the current directory.')
            ->addArgument('host', InputArgument::REQUIRED, 'The host server to initialize with.');
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    protected function fire()
    {
        if (file_exists(getcwd().'/Diplomat.blade.php')) {
            $this->output->writeln('<error>Diplomat file already exists!</error>');

            return;
        }

        file_put_contents(getcwd().'/Diplomat.blade.php', "@servers(['web' => '".$this->input->getArgument('host')."'])

@task('deploy')
    cd /path/to/site
    git pull origin master
@endtask
");

        $this->output->writeln('<info>Diplomat file created!</info>');
    }
}
