<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CountriesRepository::class)]
#[ApiResource]
class Countries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $iso = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $region = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Moment>
     */
    #[ORM\OneToMany(mappedBy: 'country_id', targetEntity: Moment::class)]
    private Collection $moments;

    /**
     * @var Collection<int, Submoment>
     */
    #[ORM\OneToMany(mappedBy: 'country_id', targetEntity: Submoment::class)]
    private Collection $date_from;

    public function __construct()
    {
        $this->moments = new ArrayCollection();
        $this->date_from = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIso(): ?string
    {
        return $this->iso;
    }

    public function setIso(string $iso): static
    {
        $this->iso = $iso;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

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
     * @return Collection<int, Moment>
     */
    public function getMoments(): Collection
    {
        return $this->moments;
    }

    public function addMoment(Moment $moment): static
    {
        if (!$this->moments->contains($moment)) {
            $this->moments->add($moment);
            $moment->setCountryId($this);
        }

        return $this;
    }

    public function removeMoment(Moment $moment): static
    {
        if ($this->moments->removeElement($moment)) {
            // set the owning side to null (unless already changed)
            if ($moment->getCountryId() === $this) {
                $moment->setCountryId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Submoment>
     */
    public function getDateFrom(): Collection
    {
        return $this->date_from;
    }

    public function addDateFrom(Submoment $dateFrom): static
    {
        if (!$this->date_from->contains($dateFrom)) {
            $this->date_from->add($dateFrom);
            $dateFrom->setCountryId($this);
        }

        return $this;
    }

    public function removeDateFrom(Submoment $dateFrom): static
    {
        if ($this->date_from->removeElement($dateFrom)) {
            // set the owning side to null (unless already changed)
            if ($dateFrom->getCountryId() === $this) {
                $dateFrom->setCountryId(null);
            }
        }

        return $this;
    }
}
