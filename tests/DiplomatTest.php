<?php

namespace Sanuj\Diplomat;

class DiplomatTest extends TestCase
{
	public function test_it_returns_output_and_exit_code_on_one_host()
    {
    	$host = ['127.0.0.1'];
        $diplomat = new Diplomat();
        $returned = $diplomat->run($host, file_get_contents(
        	__DIR__ . '/../scripts/script.sh'));
        
        $expected = $this->expected_return_array($host, 'IT WORKS!', 0);
        $this->assertEquals($expected, $returned);
    }

    public function expected_return_array($hosts, $output_lines, $exit_code) {
    	$lines = explode("\n", $output_lines);

    	$output = [];
    	foreach($hosts as $host) {
    		foreach($lines as $line) {
    			$output[] = '['.$host.']: ' . trim($line) . PHP_EOL;
    		}
    	}
    	return [
    		'output' => $output,
    		'exit_code' => $exit_code
    	];
    }
}
