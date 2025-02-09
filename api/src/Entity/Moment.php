<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MomentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MomentRepository::class)]
#[ApiResource]
class Moment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'moments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_from = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_to = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $exact_date = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    /**
     * @var Collection<int, Country>
     */
    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: 'moments')]
    private Collection $county_id;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Submoment>
     */
    #[ORM\OneToMany(targetEntity: Submoment::class, mappedBy: 'moment_id', orphanRemoval: true)]
    private Collection $submoments;

    public function __construct()
    {
        $this->county_id = new ArrayCollection();
        $this->submoments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

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

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountyId(): Collection
    {
        return $this->county_id;
    }

    public function addCountyId(Country $countyId): static
    {
        if (!$this->county_id->contains($countyId)) {
            $this->county_id->add($countyId);
        }

        return $this;
    }

    public function removeCountyId(Country $countyId): static
    {
        $this->county_id->removeElement($countyId);

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

    /**
     * @return Collection<int, Submoment>
     */
    public function getSubmoments(): Collection
    {
        return $this->submoments;
    }

    public function addSubmoment(Submoment $submoment): static
    {
        if (!$this->submoments->contains($submoment)) {
            $this->submoments->add($submoment);
            $submoment->setMomentId($this);
        }

        return $this;
    }

    public function removeSubmoment(Submoment $submoment): static
    {
        if ($this->submoments->removeElement($submoment)) {
            // set the owning side to null (unless already changed)
            if ($submoment->getMomentId() === $this) {
                $submoment->setMomentId(null);
            }
        }

        return $this;
    }
}
