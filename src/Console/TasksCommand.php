<?php

namespace Sanuj\Diplomat\Console;

use Sanuj\Diplomat\Compiler;
use Sanuj\Diplomat\TaskContainer;

class TasksCommand extends \Symfony\Component\Console\Command\Command
{
    use Command;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('tasks')
                ->setDescription('Lists all Diplomat tasks and macros.');
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    protected function fire()
    {
        $container = $this->loadTaskContainer();

        $this->listTasks($container);

        $this->output->writeln('');

        $this->listMacros($container);
    }

    /**
     * List the tasks from the container.
     *
     * @param  \Sanuj\Diplomat\TaskContainer  $container
     * @return void
     */
    protected function listTasks($container)
    {
        $this->output->writeln('<comment>Available tasks:</comment>');

        foreach (array_keys($container->getTasks()) as $task) {
            $this->output->writeln("  <info>{$task}</info>");
        }
    }

    /**
     * List the macros from the container.
     *
     * @param  \Sanuj\Diplomat\TaskContainer  $container
     * @return void
     */
    protected function listMacros($container)
    {
        $this->output->writeln('<comment>Available stories:</comment>');

        foreach (array_keys($container->getMacros()) as $macro) {
            $this->output->writeln("  <info>{$macro}</info>");
        }
    }

    /**
     * Load the task container instance with the Diplomat file.
     *
     * @return \Sanuj\Diplomat\TaskContainer
     */
    protected function loadTaskContainer()
    {
        if (! file_exists($envoyFile = getcwd().'/Diplomat.blade.php')) {
            echo "Diplomat.blade.php not found.\n";

            exit(1);
        }

        with($container = new TaskContainer)->load($envoyFile, new Compiler);

        return $container;
    }
}
