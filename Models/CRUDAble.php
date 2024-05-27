<?php
abstract class CRUDAble
{
    const PAGE_SIZE = 10;

    protected function getPDO(): PDO
    {
        return PDOProvider::getPDO();
    }

    public function __construct()
    {
    }

    /**
     * Sauvegarde l'entité dans la base de données en se basant sur les champs renseignés dans l'instance de l'objet.
     * @return bool Indique si l'opération de sauvegarde a réussi
     */
    public abstract function save(): bool;
}