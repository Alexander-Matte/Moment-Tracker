<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SubmomentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SubmomentRepository::class)]
#[ApiResource]
class Submoment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'submoments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Moment $moment_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitute = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'date_from')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Countries $country_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_from = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_to = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $exact_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getMomentId(): ?Moment
    {
        return $this->moment_id;
    }

    public function setMomentId(?Moment $moment_id): static
    {
        $this->moment_id = $moment_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLatitute(): ?float
    {
        return $this->latitute;
    }

    public function setLatitute(?float $latitute): static
    {
        $this->latitute = $latitute;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCountryId(): ?Countries
    {
        return $this->country_id;
    }

    public function setCountryId(?Countries $country_id): static
    {
        $this->country_id = $country_id;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->date_from;
    }

    public function setDateFrom(?\DateTimeInterface $date_from): static
    {
        $this->date_from = $date_from;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->date_to;
    }

    public function setDateTo(?\DateTimeInterface $date_to): static
    {
        $this->date_to = $date_to;

        return $this;
    }

    public function getExactDate(): ?\DateTimeInterface
    {
        return $this->exact_date;
    }

    public function setExactDate(?\DateTimeInterface $exact_date): static
    {
        $this->exact_date = $exact_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
