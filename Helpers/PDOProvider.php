<?php

class PDOProvider
{
    private static PDO|null $pdo = null;

    public static function getPDO(): PDO
    {
        if (PDOProvider::$pdo == null)
        {
            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation mode for "real" prepared statements
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Disable errors in the form of exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Make the default fetch be an associative array
            ];
            PDOProvider::$pdo = new PDO(DB_CONNECTION_STRING, DB_USERNAME, DB_PASSWORD, $options);
            PDOProvider::$pdo->exec("set names utf8");
        }
        return PDOProvider::$pdo;
    }
}