<?php

use Cli\StringProcessor as CliStringProcessor;
use PHPUnit\Framework\TestCase;

class StringProcessorTest extends TestCase
{
    private $processor;
    private $testStr;

    protected function setUp(): void
    {
        $this->testStr = 'Тевирп! Онвад ен ьсиледив.';
        $this->processor = new CliStringProcessor($this->testStr);
    }

    protected function tearDown(): void
    {
        $this->testStr = NULL;
        $this->processor = NULL;
    }

    public function testRevert()
    {
        $result = $this->processor->revertCharacters();
        $this->assertEquals('Привет! Давно не виделись.', $result);
    }
}
