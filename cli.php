<?php

require_once  __DIR__ . '/vendor/autoload.php';

use Cli\StringProcessor;

$processor = new StringProcessor(readline('Введите фразу '));
print $processor->revertCharacters();
