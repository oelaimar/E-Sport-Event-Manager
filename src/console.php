<?php
// src/Console.php
class Console {
    public static function read(string $prompt): string {
        echo $prompt . " : ";
        return trim(fgets(STDIN));
    }

    public static function write(string $message, string $color = "white"): void {
        $colors = [
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'white' => "\033[0m"
        ];
        $c = $colors[$color] ?? $colors['white'];
        echo $c . $message . "\033[0m"; 
        // . PHP_EOL;
    }

    public static function clear(): void {
        passthru(PHP_OS_FAMILY === 'Windows' ? 'cls' : 'clear');
    }
}

$scan = new Console;