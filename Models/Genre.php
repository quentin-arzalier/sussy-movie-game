<?php

class Genre extends CRUDAble
{

    private int $id_genre;
    private string $genre;

    public function __construct()
    {
        parent::__construct();
    }

    public function getIdGenre(): int
    {
        return $this->id_genre;
    }

    public function setIdGenre(int $id_genre): void
    {
        $this->id_genre = $id_genre;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    public static function CreateGenre($genre_id, $genre)
    {
        $obj = new Genre();
        $obj->setIdGenre($genre_id);
        $obj->setGenre($genre);
        return $obj;
    }

    public function getAllGenres(): array
    {
        $response = $this->getPDO()->query("SELECT * FROM genre");
        return $response->fetchAll(PDO::FETCH_CLASS, 'Genre');
    }

    public function get($genre_id): Genre|null
    {
        $query = $this->getPDO()->prepare("SELECT * FROM genre WHERE id_genre=:id_genre");
        $success = $query->execute(array('id_genre' => $genre_id));
        if (!$success)
            return null;
        $array = $query->fetchAll(PDO::FETCH_CLASS, "Genre");
        if (count($array) == 1)
            return $array[0];
        else
            return null;
    }

    public function save(): bool
    {
        if ($this->get($this->getIdGenre()))
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO genre(id_genre, genre) 
VALUES (:id_genre, :genre);
        ");

        return $query->execute(array(
            "id_genre" => $this->getIdGenre(),
            "genre" => $this->getGenre()
        ));
    }
}