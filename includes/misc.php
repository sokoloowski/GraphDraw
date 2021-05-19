<?php

/**
 * Read user input from standard input
 * 
 * @return string Trimmed user input
 */
function input(): string
{
    return trim(fgets(STDIN));
}

/**
 * Print error message and exit script
 * 
 * @param string $message Message to display on exit
 */
function error(string $message): void
{
    fwrite(STDERR, "Error: $message" . PHP_EOL) and exit;
}
