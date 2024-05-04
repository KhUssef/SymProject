<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?experience $req1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?experience $req2 = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $applicants;

    #[ORM\ManyToOne(inversedBy: 'employee')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $master = null;

    #[ORM\ManyToOne(inversedBy: 'accomplishment')]
    private ?User $employee = null;

    public function __construct()
    {
        $this->applicants = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getReq1(): ?experience
    {
        return $this->req1;
    }

    public function setReq1(?experience $req1): static
    {
        $this->req1 = $req1;

        return $this;
    }

    public function getReq2(): ?experience
    {
        return $this->req2;
    }

    public function setReq2(?experience $req2): static
    {
        $this->req2 = $req2;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getApplicants(): Collection
    {
        return $this->applicants;
    }

    public function addApplicant(User $applicant): static
    {
        if (!$this->applicants->contains($applicant)) {
            $this->applicants->add($applicant);
        }

        return $this;
    }

    public function removeApplicant(User $applicant): static
    {
        $this->applicants->removeElement($applicant);

        return $this;
    }

    public function getMaster(): ?User
    {
        return $this->master;
    }

    public function setMaster(?User $master): static
    {
        $this->master = $master;

        return $this;
    }

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): static
    {
        $this->employee = $employee;

        return $this;
    }
}
