<?php

class MovieListDTO implements JsonSerializable
{
    private int $currentPage;
    private int $totalMovies;
    private array $movies;

    /**
     * @param int $currentPage
     * @param int $totalMovies
     * @param array $movies
     */
    public function __construct(int $currentPage, int $totalMovies, array $movies)
    {
        $this->currentPage = $currentPage;
        $this->totalMovies = $totalMovies;
        $this->movies = $movies;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }

    public function getTotalMovies(): int
    {
        return $this->totalMovies;
    }

    public function setTotalMovies(int $totalMovies): void
    {
        $this->totalMovies = $totalMovies;
    }

    public function getMovies(): array
    {
        return $this->movies;
    }

    public function setMovies(array $movies): void
    {
        $this->movies = $movies;
    }


    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}