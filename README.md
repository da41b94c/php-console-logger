# PHP Console (CLI helper)

Tiny `Console` class for PHP 7.3+ cron/CLI scripts:
- Color output via ANSI (only when TTY)
- Disable colors with `NO_COLOR=1`
- Errors go to `STDERR`
- `Key: Value` aligned output
- Strips ANSI/control chars from user-provided text (basic terminal injection protection)

## Install

Just copy `src/Console.php` into your project and `require_once` it.

## Usage

```php
require_once __DIR__ . '/src/Console.php';

Console::Info("Cron started");
Console::Kv("EAN", "4000530391957");
Console::Success("Sent to Amazon");
Console::Warn("Price is empty - skip");
Console::Error("API failed: 429 Too Many Requests");
