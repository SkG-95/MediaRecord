<?php
// src/Entity/Upcoming.php

namespace App\Entity;

use App\Repository\UpcomingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UpcomingRepository::class)]
class Upcoming
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'boolean')]
    private bool $adult;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $backdropPath = null;

    #[ORM\Column(type: 'json')]
    private array $genreIds = [];

    #[ORM\Column(type: 'integer')]
    private int $tmdbId;

    #[ORM\Column(type: 'string', length: 10)]
    private string $originalLanguage;

    #[ORM\Column(type: 'string', length: 255)]
    private string $originalTitle;

    #[ORM\Column(type: 'text')]
    private string $overview;

    #[ORM\Column(type: 'float')]
    private float $popularity;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $posterPath = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $releaseDate;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'boolean')]
    private bool $video;

    #[ORM\Column(type: 'float')]
    private float $voteAverage;

    #[ORM\Column(type: 'integer')]
    private int $voteCount;

    // --- GETTERS & SETTERS ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAdult(): bool
    {
        return $this->adult;
    }

    public function setAdult(bool $adult): self
    {
        $this->adult = $adult;
        return $this;
    }

    public function getBackdropPath(): ?string
    {
        return $this->backdropPath;
    }

    public function setBackdropPath(?string $backdropPath): self
    {
        $this->backdropPath = $backdropPath;
        return $this;
    }

    public function getGenreIds(): array
    {
        return $this->genreIds;
    }

    public function setGenreIds(array $genreIds): self
    {
        $this->genreIds = $genreIds;
        return $this;
    }

    public function getTmdbId(): int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(int $tmdbId): self
    {
        $this->tmdbId = $tmdbId;
        return $this;
    }

    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(string $originalLanguage): self
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }

    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(string $originalTitle): self
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): self
    {
        $this->overview = $overview;
        return $this;
    }

    public function getPopularity(): float
    {
        return $this->popularity;
    }

    public function setPopularity(float $popularity): self
    {
        $this->popularity = $popularity;
        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->posterPath;
    }

    public function setPosterPath(?string $posterPath): self
    {
        $this->posterPath = $posterPath;
        return $this;
    }

    public function getReleaseDate(): \DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function isVideo(): bool
    {
        return $this->video;
    }

    public function setVideo(bool $video): self
    {
        $this->video = $video;
        return $this;
    }

    public function getVoteAverage(): float
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(float $voteAverage): self
    {
        $this->voteAverage = $voteAverage;
        return $this;
    }

    public function getVoteCount(): int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;
        return $this;
    }
}
