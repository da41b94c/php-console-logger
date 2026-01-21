<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Da41b94c\ConsoleLogger\Console;

Console::Info("Started");
Console::Kv("id", "777");
Console::Success("OK");
Console::Warn("id is empty");
Console::Error("API failed: 429 Too Many Requests");