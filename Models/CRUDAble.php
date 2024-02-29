<?php
abstract class CRUDAble
{


    /**
     * @var PDO
     */
    private $pdo;

    public function __construct()
    {
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Disable errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Make the default fetch be an associative array
        ];
        $this->pdo = new PDO(DB_CONNECTION_STRING, DB_USERNAME, DB_PASSWORD, $options);
        $this->pdo->exec("set names utf8");
    }

    protected function getPDO()
    {
        return $this->pdo;
    }
}