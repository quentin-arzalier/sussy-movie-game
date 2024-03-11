<?php
Class Director extends CRUDAble{

    private int $id_director;
    private string $full_name;

    public function __construct(){
        parent::__construct();
    }

    public function getIdDirector(): int{
        return $this->id_director;
    }

    public function setIdDirector(int $id_director): void{
        $this->id_director = $id_director;
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): void
    {
        $this->full_name = $full_name;
    }


    public static function CreateDirector(int $id_director, string $full_name): Director
    {
        $dir = new Director();
        $dir->setIdDirector($id_director);
        $dir->setFullName($full_name);
        return $dir;
    }

    public function get(int $id_director): Director|null {
        $query = $this->getPDO()->prepare("
SELECT * FROM director
WHERE id_director=:id_director
        ");
        $response = $query->execute(array('id_director' => $id_director));
        if (!$response)
            return null;

        $array = $query->fetchAll(PDO::FETCH_CLASS, 'Director');

        if (count($array) == 1)
            return $array[0];
        else
            return null;
    }


    public function save(): bool
    {
        if ($this->get($this->getIdDirector()))
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO director(id_director, full_name) 
VALUES(:id_director, :full_name);
        ");

        return $query->execute(array(
           "id_director" => $this->getIdDirector(),
           "full_name" => $this->getFullName()
        ));
    }


}