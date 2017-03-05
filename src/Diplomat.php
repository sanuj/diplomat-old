<?php

namespace Sanuj\Diplomat;

use Symfony\Component\Process\Process;

class Diplomat
{
    /**
     * Output of task.
     *
     * @var array
     */
    protected $output = [];

/**
     * Run script on given hosts and return output and exit code.
     *
     * @param  array  $hosts
     * @param  string  $script
     * @return array
     */
    public function run($hosts = [], $script) {
        $exit_code = $this->runTaskOverSSH(new Task($hosts, null, $script));
        return [
            'output' => $this->output,
            'exit_code' => $exit_code
        ];
    }

    /**
     * Run the given task and update output.
     *
     * @param  \Sanuj\Diplomat\Task  $task
     * @return void
     */
    protected function runTaskOverSSH(Task $task) {
        $ssh = new SSH($task);
        return $ssh->run($task, function($type, $host, $line) {
            if (starts_with($line, 'Warning: Permanently added ')) {
                return;
            }

            $this->displayOutput($type, $host, $line);
        });

    }

    /**
     * Display the given output line.
     *
     * @param  int  $type
     * @param  string  $host
     * @param  string  $line
     * @return void
     */
    protected function displayOutput($type, $host, $line)
    {
        $lines = explode("\n", $line);

        foreach ($lines as $line) {
            if (strlen(trim($line)) === 0) {
                continue;
            }

            if ($type == Process::OUT) {
                $this->output[] = '['.$host.']: '.trim($line).PHP_EOL;
            } else {
                $this->output[] = '['.$host.'] Error: '.trim($line).PHP_EOL;
            }
        }
    }
}
