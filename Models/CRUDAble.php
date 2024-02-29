<?php
abstract class CRUDAble
{
    private PDO $pdo;

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

    protected function getPDO(): PDO
    {
        return $this->pdo;
    }

    /**
     * Sauvegarde l'entité dans la base de données en se basant sur les champs renseignés dans l'instance de l'objet.
     * @return bool Indique si l'opération de sauvegarde a réussi
     */
    public abstract function save(): bool;
}