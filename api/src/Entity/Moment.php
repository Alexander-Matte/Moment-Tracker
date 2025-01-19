<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MomentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MomentRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['moment:read']],
    denormalizationContext: ['groups' => ['moment:create', 'moment:update']],
)]
class Moment
{
    #[Groups(['moment:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['moment:read'])]
    #[ORM\ManyToOne(inversedBy: 'moments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_from = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_to = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $exact_date = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\Column(length: 50)]
    private ?string $region = null;

    #[Groups(['moment:read','moment:create', 'moment:update'])]
    #[ORM\ManyToOne(inversedBy: 'moments')]
    private ?Country $country = null;

    #[Groups(['moment:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[Groups(['moment:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Submoment>
     */
    #[Groups(['moment:read'])]
    #[ORM\OneToMany(mappedBy: 'moment_id', targetEntity: Submoment::class)]
    private Collection $submoments;

    public function __construct()
    {
        $this->submoments = new ArrayCollection();
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

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

    public function getCountryId(): ?Country
    {
        return $this->country_id;
    }

    public function setCountryId(?Country $country_id): static
    {
        $this->country_id = $country_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->created_at = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updated_at = new \DateTimeImmutable();

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
