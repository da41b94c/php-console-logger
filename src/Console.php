<?php
declare(strict_types=1);

final class Console
{
	private const Esc = "\x1B[";
	private const Reset = "\x1B[0m";

	private const CInfo = "36;1";
	private const CSuccess = "32;1";
	private const CWarn = "33;1";
	private const CError = "31;1";
	private const CMuted = "90";

	public static function Write(string $Text): void
	{
		fwrite(STDOUT, $Text);
	}

	public static function WriteLn(string $Text = ''): void
	{
		fwrite(STDOUT, $Text . PHP_EOL);
	}

	public static function Err(string $Text): void
	{
		fwrite(STDERR, $Text);
	}

	public static function ErrLn(string $Text): void
	{
		fwrite(STDERR, $Text . PHP_EOL);
	}

	public static function Info(string $Text): void
	{
		$Text = self::CleanText($Text);
		self::WriteLn(self::Paint("[i] " . $Text, self::CInfo));
	}

	public static function Success(string $Text): void
	{
		$Text = self::CleanText($Text);
		self::WriteLn(self::Paint("[OK] " . $Text, self::CSuccess));
	}

	public static function Warn(string $Text): void
	{
		$Text = self::CleanText($Text);
		self::WriteLn(self::Paint("[WARN] " . $Text, self::CWarn));
	}

	public static function Error(string $Text): void
	{
		$Text = self::CleanText($Text);
		self::ErrLn(self::Paint("[ERR] " . $Text, self::CError));
	}

	public static function Debug(string $Text): void
	{
		$Text = self::CleanText($Text);
		self::WriteLn(self::Paint("[DBG] " . $Text, self::CMuted));
	}

	public static function Kv(string $Key, string $Value, int $KeyWidth = 22): void
	{
		$Key = self::CleanText($Key);
		$Value = self::CleanText($Value);

		$Key = self::PadRight($Key, $KeyWidth);
		self::WriteLn($Key . ": " . $Value);
	}

	public static function PadRight(string $Text, int $Width): string
	{
		if ($Width <= 0) {
			return $Text;
		}

		if (function_exists('mb_strwidth')) {
			$Len = (int)mb_strwidth($Text, 'UTF-8');
			$Pad = $Width - $Len;
			if ($Pad > 0) {
				return $Text . str_repeat(' ', $Pad);
			}
			return $Text;
		}

		return str_pad($Text, $Width, ' ', STR_PAD_RIGHT);
	}

	public static function Paint(string $Text, string $AnsiCode): string
	{
		if (!self::SupportsAnsi()) {
			return $Text;
		}
		return self::Esc . $AnsiCode . "m" . $Text . self::Reset;
	}

	public static function SupportsAnsi(): bool
	{
		if (getenv('NO_COLOR') !== false) {
			return false;
		}

		if (!self::IsTty(STDOUT)) {
			return false;
		}

		$Term = (string)getenv('TERM');
		if ($Term === '' || $Term === 'dumb') {
			return false;
		}

		return true;
	}

	public static function IsTty($Stream): bool
	{
		if (function_exists('stream_isatty')) {
			return @stream_isatty($Stream);
		}
		if (function_exists('posix_isatty')) {
			return @posix_isatty($Stream);
		}
		return false;
	}

	public static function CleanText(string $Text): string
	{
		$Text = (string)preg_replace('/\x1B\[[0-?]*[ -\/]*[@-~]/', '', $Text);
		$Text = (string)preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $Text);
		return $Text;
	}
}
