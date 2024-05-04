<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $fullName = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?experience $exp1 = null;

    #[ORM\ManyToOne]
    private ?experience $exp2 = null;

    #[ORM\ManyToOne]
    private ?experience $exp3 = null;

    #[ORM\ManyToOne]
    private ?experience $exp4 = null;

    /**
     * @var Collection<int, Job>
     */
    #[ORM\OneToMany(targetEntity: Job::class, mappedBy: 'master')]
    private Collection $job;

    /**
     * @var Collection<int, Job>
     */
    #[ORM\OneToMany(targetEntity: Job::class, mappedBy: 'employee')]
    private Collection $accomplishment;

    public function __construct()
    {
        $this->job = new ArrayCollection();
        $this->accomplishment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getExp1(): ?experience
    {
        return $this->exp1;
    }

    public function setExp1(?experience $exp1): static
    {
        $this->exp1 = $exp1;

        return $this;
    }

    public function getExp2(): ?experience
    {
        return $this->exp2;
    }

    public function setExp2(?experience $exp2): static
    {
        $this->exp2 = $exp2;

        return $this;
    }

    public function getExp3(): ?experience
    {
        return $this->exp3;
    }

    public function setExp3(?experience $exp3): static
    {
        $this->exp3 = $exp3;

        return $this;
    }

    public function getExp4(): ?experience
    {
        return $this->exp4;
    }

    public function setExp4(?experience $exp4): static
    {
        $this->exp4 = $exp4;

        return $this;
    }

    /**
     * @return Collection<int, Job>
     */
    public function getjob(): Collection
    {
        return $this->job;
    }

    public function addjob(Job $job): static
    {
        if (!$this->job->contains($job)) {
            $this->job->add($job);
            $job->setMaster($this);
        }

        return $this;
    }

    public function removejob(Job $job): static
    {
        if ($this->job->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getMaster() === $this) {
                $job->setMaster(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Job>
     */
    public function getAccomplishment(): Collection
    {
        return $this->accomplishment;
    }

    public function addAccomplishment(Job $accomplishment): static
    {
        if (!$this->accomplishment->contains($accomplishment)) {
            $this->accomplishment->add($accomplishment);
            $accomplishment->setEmployee($this);
        }

        return $this;
    }

    public function removeAccomplishment(Job $accomplishment): static
    {
        if ($this->accomplishment->removeElement($accomplishment)) {
            // set the owning side to null (unless already changed)
            if ($accomplishment->getEmployee() === $this) {
                $accomplishment->setEmployee(null);
            }
        }

        return $this;
    }


}
