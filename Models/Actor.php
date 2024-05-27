<?php

Class Actor extends CRUDAble{

    private int $id_actor;

    private string $full_name;
    private string|null $profile_path;

    public function __construct(){
        parent::__construct();
    }

    public function getIdActor(): int{
        return $this->id_actor;
    }

    public function setIdActor(int $id_actor): void{
        $this->id_actor = $id_actor;
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): void
    {
        $this->full_name = $full_name;
    }

    public function getProfilePath(): string|null
    {
        return $this->profile_path;
    }

    public function setProfilePath(string|null$profile_path): void
    {
        $this->profile_path = $profile_path;
    }

    public function getPictureUrl(): string
    {
        if ($this->getProfilePath() == null || $this->getProfilePath() == "")
            return "/resources/img/no_picture.jpg";
        return "https://image.tmdb.org/t/p/w45" . $this->getProfilePath();
    }

    public static function CreateActor(int $id_actor, string $full_name, string|null $profile_path): Actor
    {
        $obj = new Actor();
        $obj->setIdActor($id_actor);
        $obj->setFullName($full_name);
        $obj->setProfilePath($profile_path);

        return $obj;
    }
    public function get($actor_id): Actor|null
    {
        $query = $this->getPDO()->prepare("SELECT * FROM actor WHERE id_actor=:id_actor");
        $success = $query->execute(array('id_actor' => $actor_id));
        if (!$success)
            return null;
        $array = $query->fetchAll(PDO::FETCH_CLASS, "Actor");
        if (count($array) == 1)
            return $array[0];
        else
            return null;
    }

    public function save(): bool
    {
        if ($this->get($this->getIdActor()))
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO actor(id_actor, full_name, profile_path) 
VALUES (:id_actor, :full_name, :profile_path);
        ");

        return $query->execute(array(
            "id_actor" => $this->getIdActor(),
            "full_name" => $this->getFullName(),
            "profile_path" => $this->getProfilePath()
        ));
    }

    public function equals(Actor $other):bool
    {
        return $this->getIdActor() == $other->getIdActor();
    }

}