# php-console-logger
[![Packagist Version](https://img.shields.io/packagist/v/da41b94c/php-console-logger.svg)](https://packagist.org/packages/da41b94c/php-console-logger)
[![CI](https://github.com/da41b94c/php-console-logger/actions/workflows/ci.yml/badge.svg)](https://github.com/da41b94c/php-console-logger/actions/workflows/ci.yml)

Мини-класс `Console` для PHP 7.3+ (CLI/cron): аккуратный вывод в терминал, цвета через ANSI, ошибки в `STDERR`, отключение цветов через `NO_COLOR`, выравнивание `Key: Value`.

## Что решаем

Когда пишешь cron/CLI-скрипты, обычно хочется:
- чтобы статусы были читаемыми (`[OK]`, `[WARN]`, `[ERR]`)
- чтобы ошибки шли в `STDERR` (удобно для логов и мониторинга)

Этот класс закрывает эти задачи без зависимостей.

## Возможности

- Методы: `Info()`, `Success()`, `Warn()`, `Error()`, `Debug()`
- Ключ-значение: `Kv("id", "777")` с выравниванием
- Цвета через ANSI, только если:
	- вывод идёт в терминал (TTY)
	- `TERM` не `dumb`
	- не задано `NO_COLOR`
- Ошибки в `STDERR` (`Error()` печатает в `STDERR`)
- `CleanText()` чистит пользовательский текст от ANSI/CSI и управляющих символов

## Установка

### Через Composer (рекомендуется)

```bash
composer require da41b94c/php-console-logger
```

Дальше достаточно подключить автозагрузчик Composer (если у тебя фреймворк — скорее всего уже подключен):
```php
require_once __DIR__ . '/vendor/autoload.php';
```

### Ручная установка

Скопируй src/Console.php в проект и подключи:
```php
require_once __DIR__ . '/src/Console.php';
```

## Пример использования
В проекте с Composer
```php
require_once __DIR__ . '/vendor/autoload.php';

Console::Info("Started");
Console::Kv("id", "777");
Console::Success("OK");
Console::Warn("id is empty");
Console::Error("API failed: 429 Too Many Requests");
```

Вручную (без Composer)
```php
require_once __DIR__ . '/src/Console.php';

Console::Info("Started");
Console::Kv("id", "777");
Console::Success("OK");
Console::Warn("id is empty");
Console::Error("API failed: 429 Too Many Requests");
```

## Отключение цветов

Если нужно принудительно отключить цвета (например, для логов):
```bash
NO_COLOR=1 php examples/demo.php
```
