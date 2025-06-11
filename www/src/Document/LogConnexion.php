<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class LogConnexion
{
    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: "string")]
    private $userEmail;

    #[MongoDB\Field(type: "string")]
    private $ip;

    #[MongoDB\Field(type: "date")]
    private $date;

    public function __construct(string $userEmail, string $ip)
    {
        $this->userEmail = $userEmail;
        $this->ip = $ip;
        $this->date = new \DateTime();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;
        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }
}
