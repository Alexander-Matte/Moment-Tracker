<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 3)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Moment>
     */
    #[ORM\ManyToMany(targetEntity: Moment::class, mappedBy: 'county_id')]
    private Collection $moments;

    /**
     * @var Collection<int, Submoment>
     */
    #[ORM\OneToMany(targetEntity: Submoment::class, mappedBy: 'county_id')]
    private Collection $submoments;

    public function __construct()
    {
        $this->moments = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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
            $moment->addCountyId($this);
        }

        return $this;
    }

    public function removeMoment(Moment $moment): static
    {
        if ($this->moments->removeElement($moment)) {
            $moment->removeCountyId($this);
        }

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
            $submoment->setCountyId($this);
        }

        return $this;
    }

    public function removeSubmoment(Submoment $submoment): static
    {
        if ($this->submoments->removeElement($submoment)) {
            // set the owning side to null (unless already changed)
            if ($submoment->getCountyId() === $this) {
                $submoment->setCountyId(null);
            }
        }

        return $this;
    }
}
