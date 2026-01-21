<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Console.php';

Console::Info("Started");
Console::Kv("id", "777");
Console::Success("OK");
Console::Warn("id is empty");
Console::Error("API failed: 429 Too Many Requests");