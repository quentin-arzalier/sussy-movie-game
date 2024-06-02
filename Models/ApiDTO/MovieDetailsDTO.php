<?php

class MovieDetailsDTO implements JsonSerializable
{
    private int $id_movie;
    private string $original_name;
    private string $release_date;
    private int $runtime;
    private string|null $backdrop_path;
    private string|null $poster_path;
    private array $actors;
    private array $directors;
    private array $genres;
    private array $translations;

    /**
     * @param Movie $movie
     */
    public function __construct(Movie $movie)
    {
        $this->id_movie = $movie->getIdMovie();
        $this->original_name = $movie->getOriginalName();
        $this->release_date = $movie->getReleaseDate();
        $this->runtime = $movie->getRuntime();
        $this->backdrop_path = $movie->getBackdropPath();
        $this->poster_path = $movie->getPosterPath();
        $this->actors = $movie->getActors();
        $this->directors = $movie->getDirectors();
        $this->genres = $movie->getTop3Genres();
        $this->translations = $movie->getTranslations();
    }

    public function getIdMovie(): int
    {
        return $this->id_movie;
    }

    public function setIdMovie(int $id_movie): void
    {
        $this->id_movie = $id_movie;
    }

    public function getOriginalName(): string
    {
        return $this->original_name;
    }

    public function setOriginalName(string $original_name): void
    {
        $this->original_name = $original_name;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function setReleaseDate(string $release_date): void
    {
        $this->release_date = $release_date;
    }

    public function getRuntime(): int
    {
        return $this->runtime;
    }

    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    public function getBackdropPath(): ?string
    {
        return $this->backdrop_path;
    }

    public function setBackdropPath(?string $backdrop_path): void
    {
        $this->backdrop_path = $backdrop_path;
    }

    public function getPosterPath(): ?string
    {
        return $this->poster_path;
    }

    public function setPosterPath(?string $poster_path): void
    {
        $this->poster_path = $poster_path;
    }

    public function getActors(): array
    {
        return $this->actors;
    }

    public function setActors(array $actors): void
    {
        $this->actors = $actors;
    }

    public function getDirectors(): array
    {
        return $this->directors;
    }

    public function setDirectors(array $directors): void
    {
        $this->directors = $directors;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    public function setTranslations(array $translations): void
    {
        $this->translations = $translations;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}