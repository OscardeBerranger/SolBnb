<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $bookStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $bookEnd = null;

    #[ORM\OneToOne(inversedBy: 'reservation')]
    private ?Property $property = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $profile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookStart(): ?\DateTimeInterface
    {
        return $this->bookStart;
    }

    public function setBookStart(\DateTimeInterface $bookStart): static
    {
        $this->bookStart = $bookStart;

        return $this;
    }

    public function getBookEnd(): ?\DateTimeInterface
    {
        return $this->bookEnd;
    }

    public function setBookEnd(\DateTimeInterface $bookEnd): static
    {
        $this->bookEnd = $bookEnd;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        $this->property = $property;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }
}
